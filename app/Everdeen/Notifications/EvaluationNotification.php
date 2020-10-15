<?php
/**
 * @author Thang.Nguyen
 * @since 3/8/2017
 */

namespace Katniss\Everdeen\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Katniss\Everdeen\Mail\BaseMailable;
use Katniss\Everdeen\Models\CourseSession;
use Katniss\Everdeen\Utils\Settings;
use Katniss\Everdeen\Models\SysToken;
use Katniss\Everdeen\Models\User;
use Katniss\Everdeen\Models\Review;
use Katniss\Everdeen\Models\Tag;
use Katniss\Everdeen\Utils\DateTimeHelper;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\File;
use Katniss\Everdeen\Utils\Storage\StoreFile;
use Katniss\Everdeen\Repositories\ReviewRepository;

class EvaluationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $sessionId;
    protected $settings;
    protected $user;
    protected $review;
    protected $numHoursReview;
    protected $evaNo;
    
    public function __construct(User $user, Review $review, $sessionId, Settings $settings, $numHoursReview = 1)
    {
        $this->sessionId = $sessionId;
        $this->settings = $settings;
        $this->user = $user;
        $this->review = $review;
        $this->numHoursReview = $numHoursReview;
        $this->evaNo = 1;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        
        $session = CourseSession::findOrFail($this->sessionId);
        $review = (new ReviewRepository())->getReviewByCurrentSession($session);
        $course = $session->course;
        $key = strtolower(str_random(128));
        $token = SysToken::create([
            'token' => $key,
            'meta' => [
                'course_id' => $course->id,
                'final_rate' => 0,
                'hours' => intval($this->numHoursReview),
                'for_update' => $review ? 1 : 0,
            ],
            'type' => SysToken::TYPE_RATE_AFTER_HOUR,
        ]);

        $studentProfile = $course->studentUserProfile;
        $teacherProfile = $course->teacherUserProfile;
        $path = storage_path('app/evaluation');
        if (!is_dir($path)) {
            File::makeDirectory($path, 0777, true);
        }
        $pdf = SnappyPdf::loadView('pdf.evaluation.' . currentLocaleCode()
                , $this->formatData($this->review, $course, $session));
        $filePath = $path . '/' . randomizeFilename() . '.pdf';
        $pdf->save($filePath);
        
        return (new BaseMailable('send_evaluation', [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $this->user->email,
            BaseMailable::EMAIL_TO_NAME => $this->user->display_name,
            BaseMailable::EMAIL_SUBJECT => 'Bảng đánh giá định kỳ số ' . $this->evaNo . ' - HV ' . $studentProfile->shown_name,
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'email' => $this->user->email,
            'teacher_name' => $teacherProfile->shown_name,
            'teacher_avatar' => $teacherProfile->url_avatar,
            'url_rating_review' => baseUrl('rating-review?token=' . $token->token, [], $this->settings->getBaseUrl()),
        ], currentLocaleCode()))->attach($filePath, ['as' => 'PeriodicReview.pdf', 'mime' => 'application/pdf']);
    }

    private function formatData($review, $course, $session){
        $overallScore = 0;
        $readScore = 0;
        $writeScore = 0;
        $speakScore = 0;
        $listenScore = 0;

        $countPro = 0;

        $hours = 0;

        $duration = CourseSession::where('occurred_at', '<=', $session->occurred_at)
                    ->where('course_id', '=', $course->id)
                    ->where('teacher_confirmed', '=', 1)
                    ->whereIn('type', [CourseSession::TYPE_NORMAL, CourseSession::TYPE_MAKEUP])
                    ->sum('duration');
        $loop = $course->tags()->where('id', '=', Tag::TAG_KID_ID)->count() > 0 
                ? Review::LOOP_KID : Review::LOOP_WORK;

        if ($duration < $loop) {
            $hours = 5;
            $this->evaNo = 1;
        } else {
            $periodNo = intval($duration / $loop);
            $hours = $periodNo * $loop;
            $this->evaNo = $periodNo + 1;
        }

        foreach($review->rates as $key => $value)
        {
            if(isset($review->rates[$key]['checked']) && $review->rates[$key]['checked'] == true)
            {
                $countPro++;
                switch($key) {
                    case 'read':
                        $readScore = $this->scoring('read', $review);
                        break;
                    case 'write':
                        $writeScore = $this->scoring('write', $review);
                        break;
                    case 'speak':
                        $speakScore = $this->scoring('speak', $review);
                        break;
                    case 'listen':
                        $listenScore = $this->scoring('listen', $review);
                        break;
                }
            }
        }

        $overallScore = floatval($readScore + $writeScore 
                        + $speakScore + $listenScore)/($countPro == 0 ? 1 : $countPro);

        return [
            'scores' => [
                'read' => $readScore,
                'write' => $writeScore,
                'speak' => $speakScore,
                'listen' => $listenScore,
            ],
            'hours' => $hours,
            'course' => $course,
            'teacher' => [
                'shown_name' => $course->teacher->userProfile->shown_name
            ],
            'student' => [
                'shown_name' => $course->student->userProfile->shown_name
            ],
            'review' => $review,
            'overall_score' => $overallScore,
        ];
    }

    private function scoring($key, $review){
        $count = 0;
        $sum = 0;
        foreach($review->rates[$key]['detail'] as $opt => $value){
            if($review->rates[$key]['detail'][$opt]['checked'])
            {
                $count++;
                $sum += $review->rates[$key]['detail'][$opt]['score'];
            }
        }

        return $sum / ($count == 0 ? 1 : $count);
    }
}