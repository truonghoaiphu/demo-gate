<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Katniss\Everdeen\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->tagType();
        $this->tagProblem();
        $this->tagGroups();
    }

    protected function tagGroups()
    {
        $groupTeachingType = DB::table('tag_groups')->insertGetId([
            'name' => 'Teaching Types',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $groupTeachingTypeDetails = DB::table('tag_groups')->insertGetId([
            'name' => 'Teaching Detail Types',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $groupCourseProblem = DB::table('tag_groups')->insertGetId([
            'name' => 'Course Problems',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('tags_groups')->insert([
            'group_id' => 1,
            'tag_id' => 1,
        ]);
        DB::table('tags_groups')->insert([
            'group_id' => 1,
            'tag_id' => 2,
        ]);
        DB::table('tags_groups')->insert([
            'group_id' => 2,
            'tag_id' => 3,
        ]);
        DB::table('tags_groups')->insert([
            'group_id' => 2,
            'tag_id' => 4,
        ]);
        DB::table('tags_groups')->insert([
            'group_id' => 2,
            'tag_id' => 5,
        ]);
        DB::table('tags_groups')->insert([
            'group_id' => 2,
            'tag_id' => 6,
        ]);
        DB::table('tags_groups')->insert([
            'group_id' => 2,
            'tag_id' => 7,
        ]);
        DB::table('tags_groups')->insert([
            'group_id' => 3,
            'tag_id' => 8,
        ]);
        DB::table('tags_groups')->insert([
            'group_id' => 3,
            'tag_id' => 9,
        ]);
        DB::table('tags_groups')->insert([
            'group_id' => 3,
            'tag_id' => 10,
        ]);
        DB::table('tags_groups')->insert([
            'group_id' => 3,
            'tag_id' => 11,
        ]);
        DB::table('tags_groups')->insert([
            'group_id' => 3,
            'tag_id' => 12,
        ]);
        DB::table('tags_groups')->insert([
            'group_id' => 3,
            'tag_id' => 13,
        ]);
    }

    protected function tagType()
    {
        $data = [
            [
                'slug' => 'kid',
                'color' => '#' . randomColorToHex(),
                'translations' => [
                    'en' => [
                        'name' => 'Kid',
                        'description' => '',
                    ],
                    'vi' => [
                        'name' => 'Trẻ em',
                        'description' => '',
                    ],
                ],
            ],
            [
                'slug' => 'work',
                'color' => '#' . randomColorToHex(),
                'translations' => [
                    'en' => [
                        'name' => 'Work',
                        'description' => '',
                    ],
                    'vi' => [
                        'name' => 'Người đi làm',
                        'description' => '',
                    ],
                ],
            ],
            [
                'slug' => 'b2b',
                'color' => '#' . randomColorToHex(),
                'translations' => [
                    'en' => [
                        'name' => 'B2B',
                        'description' => '',
                    ],
                    'vi' => [
                        'name' => 'B2B',
                        'description' => '',
                    ],
                ],
            ],
            [
                'slug' => 'kid-communication',
                'color' => '#' . randomColorToHex(),
                'translations' => [
                    'en' => [
                        'name' => 'Kid - Communication',
                        'description' => '',
                    ],
                    'vi' => [
                        'name' => 'Trẻ em - Giao tiếp',
                        'description' => '',
                    ],
                ],
            ],
            [
                'slug' => 'kid-exam-preparation',
                'color' => '#' . randomColorToHex(),
                'translations' => [
                    'en' => [
                        'name' => 'Kid - Exam Preparation',
                        'description' => '',
                    ],
                    'vi' => [
                        'name' => 'Trẻ em - Chuẩn bị cho kỳ thi',
                        'description' => '',
                    ],
                ],
            ],
            [
                'slug' => 'work-communication',
                'color' => '#' . randomColorToHex(),
                'translations' => [
                    'en' => [
                        'name' => 'Work - Communication',
                        'description' => '',
                    ],
                    'vi' => [
                        'name' => 'Người đi làm - Giao tiếp',
                        'description' => '',
                    ],
                ],
            ],
            [
                'slug' => 'work-exam-preparation',
                'color' => '#' . randomColorToHex(),
                'translations' => [
                    'en' => [
                        'name' => 'Work - Exam Preparation',
                        'description' => '',
                    ],
                    'vi' => [
                        'name' => 'Người đi làm - Chuẩn bị cho kỳ thi',
                        'description' => '',
                    ],
                ],
            ],
            [
                'slug' => 'work-technical-english',
                'color' => '#' . randomColorToHex(),
                'translations' => [
                    'en' => [
                        'name' => 'Work - Technical English',
                        'description' => '',
                    ],
                    'vi' => [
                        'name' => 'Người đi làm - Tiếng Anh chuyên ngành',
                        'description' => '',
                    ],
                ],
            ],
        ];

        foreach ($data as $item) {
            $tag = new Tag();
            $tag->slug = $item['slug'];
            $tag->color = $item['color'];
            foreach ($item['translations'] as $locale => $transData) {
                $trans = $tag->translateOrNew($locale);
                $trans->name = $transData['name'];
                $trans->description = $transData['description'];
            }
            $tag->save();
        }
    }

    protected function tagProblem()
    {
        $data = [
            [
                'slug' => 'learner-s-improvement',
                'color' => '#0000ff',
                'translations' => [
                    'en' => [
                        'name' => 'Learner\'s Improvement',
                        'description' => '',
                    ],
                    'vi' => [
                        'name' => 'Cải thiện trình độ học viên',
                        'description' => '',
                    ],
                ],
            ],
            [
                'slug' => 'attitude',
                'color' => '#6600cc',
                'translations' => [
                    'en' => [
                        'name' => 'Attitude',
                        'description' => '',
                    ],
                    'vi' => [
                        'name' => 'Thái độ',
                        'description' => '',
                    ],
                ],
            ],
            [
                'slug' => 'tc-level-misalignment',
                'color' => '#009933',
                'translations' => [
                    'en' => [
                        'name' => 'TC - Level misalignment',
                        'description' => '',
                    ],
                    'vi' => [
                        'name' => 'ND - Thiếu sắp xếp theo cấp độ',
                        'description' => '',
                    ],
                ],
            ],
            [
                'slug' => 'tc-uninteresting-content',
                'color' => '#ff9900',
                'translations' => [
                    'en' => [
                        'name' => 'TC - Uninteresting content',
                        'description' => '',
                    ],
                    'vi' => [
                        'name' => 'ND - Nội dung không thú vị',
                        'description' => '',
                    ],
                ],
            ],
            [
                'slug' => 'tc-confusing-structure',
                'color' => '#6666ff',
                'translations' => [
                    'en' => [
                        'name' => 'TC - Confusing structure',
                        'description' => '',
                    ],
                    'vi' => [
                        'name' => 'ND - Cấu trúc khó hiểu',
                        'description' => '',
                    ],
                ],
            ],
            [
                'slug' => 'teaching-method',
                'color' => '#ff66ff',
                'translations' => [
                    'en' => [
                        'name' => 'Teaching Method',
                        'description' => '',
                    ],
                    'vi' => [
                        'name' => 'Phương pháp giảng dạy',
                        'description' => '',
                    ],
                ],
            ],
        ];

        foreach ($data as $item) {
            $tag = new Tag();
            $tag->slug = $item['slug'];
            $tag->color = $item['color'];
            foreach ($item['translations'] as $locale => $transData) {
                $trans = $tag->translateOrNew($locale);
                $trans->name = $transData['name'];
                $trans->description = $transData['description'];
            }
            $tag->save();
        }
    }
}
