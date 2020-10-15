<?php
namespace Katniss\Everdeen\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Katniss\Everdeen\Models\Channel;
use Katniss\Everdeen\Models\Teacher;
use Katniss\Everdeen\Models\TeacherGroup;

class NewlyTeacherNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $teacher;

    public function __construct(Teacher $teacher, $source = null)
    {
        $this->teacher = $teacher;
    }

    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    public function toArray()
    {
        $user = $this->teacher->userProfile;
        $teacherGroup = null;
        if ($user->nationality_id) {
            $teacherGroups = TeacherGroup::where('type', TeacherGroup::TYPE_COUNTRY)->get();
            $configTeacherGroups = teacherGroup();
            foreach ($teacherGroups as $group) {
                if (in_array($user->nationality_id, $group->value) && !empty($configTeacherGroups[$group->id])) {
                    $teacherGroup = $configTeacherGroups[strval($group->id)];
                }
            }
        }
        
        return [
            'type' => Channel::TYPE_NEWLY_TEACHER,
            'teacher' => [
                'id' => $this->teacher->user_id,
                'shown_name' => $user->shown_name,
                'email' => $user->email,
                'skype' => $user->skype,
                'channel' => $teacherGroup,
            ],
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'data' => $this->toArray(),
            'created_at' => date('Y-m-d H:i:s'),
            'read_at' => null,
        ]);
    }
}