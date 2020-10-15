<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\Permission;
use Katniss\Everdeen\Models\Role;
use Katniss\Everdeen\Models\User;
use Katniss\Everdeen\Models\Conversation;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::updateOrCreate(
            ['name' => 'void'],
            [
                'display_name' => 'Void',
                'description' => 'Grant Void Permission'
            ]);

        // user perms
        $userDelete = Permission::updateOrCreate(
            ['name' => 'user-delete'],
            [
                'display_name' => 'Delete User',
                'description' => 'Grant Delete User'
            ]);

        $userCreate = Permission::updateOrCreate(
            ['name' => 'user-create'],
            [
                'display_name' => 'Create User',
                'description' => 'Grant Create User',
            ]
        );

        $userEdit = Permission::updateOrCreate(
            ['name' => 'user-edit'],
            [
                'display_name' => 'Edit User',
                'description' => 'Grant Edit User',
            ]
        );

        $userView = Permission::updateOrCreate(
            ['name' => 'user-view'],
            [
                'display_name' => 'View User',
                'description' => 'Grant View User',
            ]
        );

        // teacher perms
        $teacherDelete = Permission::updateOrCreate(
            ['name' => 'teacher-delete'],
            [
                'display_name' => 'Delete Teacher',
                'description' => 'Grant Delete Teacher',
            ]
        );

        $teacherCreate = Permission::updateOrCreate(
            ['name' => 'teacher-create'],
            [
                'display_name' => 'Create Teacher',
                'description' => 'Grant Create Teacher',
            ]
        );

        $teacherEdit = Permission::updateOrCreate(
            ['name' => 'teacher-edit'],
            [
                'display_name' => 'Edit Teacher',
                'description' => 'Grant Edit Teacher',
            ]
        );

        $teacherView = Permission::updateOrCreate(
            ['name' => 'teacher-view'],
            [
                'display_name' => 'View Teacher',
                'description' => 'Grant View Teacher',
            ]
        );

        $teacherRecruit = Permission::updateOrCreate(
            ['name' => 'teacher-recruit'],
            [
                'display_name' => 'Recruit Teacher',
                'description' => 'Recruit teacher'
            ]
        );

        $teacherInterview = Permission::updateOrCreate(
            ['name' => 'teacher-interview'],
            [
                'display_name' => 'Interview Teacher',
                'description' => 'Grant Interview Teacher',
            ]
        );

        $teacherMessageBroadcastPermission = Permission::updateOrCreate(
            ['name' => 'teacher-message-broadcast'],
            [
                'display_name' => 'Teacher Message Broadcast',
                'description' => 'Teacher message broadcast',
            ]
        );

        $teacherTrainPermission = Permission::updateOrCreate(
            ['name' => 'teacher-train'],
            [
                'display_name' => 'Teacher Train',
                'description' => 'Teacher train',
            ]
        );

        // student perms
        $studentDelete = Permission::updateOrCreate(
            ['name' => 'student-delete'],
            [
                'display_name' => 'Delete Student',
                'description' => 'Grant Delete Student'
            ]);

        $studentCreate = Permission::updateOrCreate(
            ['name' => 'student-create'],
            [
                'display_name' => 'Create Student',
                'description' => 'Grant Create Student',
            ]
        );

        $studentEdit = Permission::updateOrCreate(
            ['name' => 'student-edit'],
            [
                'display_name' => 'Edit Student',
                'description' => 'Grant Edit Student',
            ]
        );

        $studentView = Permission::updateOrCreate(
            ['name' => 'student-view'],
            [
                'display_name' => 'View Student',
                'description' => 'Grant View Student',
            ]
        );

        // role perms
        $roleDelete = Permission::updateOrCreate(
            ['name' => 'role-delete'],
            [
                'display_name' => 'Delete Role',
                'description' => 'Grant Delete Role'
            ]);

        $roleCreate = Permission::updateOrCreate(
            ['name' => 'role-create'],
            [
                'display_name' => 'Create Role',
                'description' => 'Grant Create Role',
            ]
        );

        $roleEdit = Permission::updateOrCreate(
            ['name' => 'role-edit'],
            [
                'display_name' => 'Edit Role',
                'description' => 'Grant Edit Role',
            ]
        );

        $roleView = Permission::updateOrCreate(
            ['name' => 'role-view'],
            [
                'display_name' => 'View Role',
                'description' => 'Grant View Role',
            ]
        );

        // meta perms
        $metaDelete = Permission::updateOrCreate(
            ['name' => 'meta-delete'],
            [
                'display_name' => 'Delete Meta',
                'description' => 'Grant Delete Meta'
            ]);

        $metaCreate = Permission::updateOrCreate(
            ['name' => 'meta-create'],
            [
                'display_name' => 'Create Meta',
                'description' => 'Grant Create Meta',
            ]
        );

        $metaEdit = Permission::updateOrCreate(
            ['name' => 'meta-edit'],
            [
                'display_name' => 'Edit Meta',
                'description' => 'Grant Edit Meta',
            ]
        );

        $metaView = Permission::updateOrCreate(
            ['name' => 'meta-view'],
            [
                'display_name' => 'View Meta',
                'description' => 'Grant View Meta',
            ]
        );

        // team perms
        $teamDelete = Permission::updateOrCreate(
            ['name' => 'team-delete'],
            [
                'display_name' => 'Delete Team',
                'description' => 'Grant Delete Team'
            ]);

        $teamCreate = Permission::updateOrCreate(
            ['name' => 'team-create'],
            [
                'display_name' => 'Create Team',
                'description' => 'Grant Create Team',
            ]
        );

        $teamEdit = Permission::updateOrCreate(
            ['name' => 'team-edit'],
            [
                'display_name' => 'Edit Team',
                'description' => 'Grant Edit Team',
            ]
        );

        $teamView = Permission::updateOrCreate(
            ['name' => 'team-view'],
            [
                'display_name' => 'View Team',
                'description' => 'Grant View Team',
            ]
        );

        // learning request perms
        $learningRequestView = Permission::updateOrCreate(
            ['name' => 'learning-request-view'],
            [
                'display_name' => 'View Learning Request',
                'description' => 'Grant View Learning Request'
            ]);

        $learningRequestCreate = Permission::updateOrCreate(
            ['name' => 'learning-request-create'],
            [
                'display_name' => 'Create Learning Request',
                'description' => 'Grant Create Learning Request'
            ]);

        $learningRequestEdit = Permission::updateOrCreate(
            ['name' => 'learning-request-edit'],
            [
                'display_name' => 'Edit Learning Request',
                'description' => 'Grant Edit Learning Request'
            ]);

        $learningRequestDelete = Permission::updateOrCreate(
            ['name' => 'learning-request-delete'],
            [
                'display_name' => 'Delete Learning Request',
                'description' => 'Grant Delete Learning Request'
            ]);

        $learningRequestConvert = Permission::updateOrCreate(
            ['name' => 'learning-request-convert'],
            [
                'display_name' => 'Convert Learning Request',
                'description' => 'Grant Convert Learning Request'
            ]);

        // contact perms
        $contactView = Permission::updateOrCreate(
            ['name' => 'contact-view'],
            [
                'display_name' => 'View Contact',
                'description' => 'Grant View Contact'
            ]);

        $contactCreate = Permission::updateOrCreate(
            ['name' => 'contact-create'],
            [
                'display_name' => 'Create Contact',
                'description' => 'Grant Create Contact'
            ]);

        $contactEdit = Permission::updateOrCreate(
            ['name' => 'contact-edit'],
            [
                'display_name' => 'Edit Contact',
                'description' => 'Grant Edit Contact'
            ]);

        $contactDelete = Permission::updateOrCreate(
            ['name' => 'contact-delete'],
            [
                'display_name' => 'Delete Contact',
                'description' => 'Grant Delete Contact'
            ]);

        $contactResolve = Permission::updateOrCreate(
            ['name' => 'contact-resolve'],
            [
                'display_name' => 'Resolve Contact',
                'description' => 'Grant Resolve Contact'
            ]);

        $contactDivide = Permission::updateOrCreate(
            ['name' => 'contact-divide'],
            [
                'display_name' => 'Divide Contact',
                'description' => 'Grant Divide Contact'
            ]);

        $contactCare = Permission::updateOrCreate(
            ['name' => 'contact-care'],
            [
                'display_name' => 'Care Contact',
                'description' => 'Grant Care Contact',
            ]);

        $contactTeamReportPermission = Permission::updateOrCreate(
            ['name' => 'contact-team-report'],
            [
                'display_name' => 'Contact Team Report',
                'description' => 'Grant Contact Team Report',
            ]
        );

        // customer perms
        $customerView = Permission::updateOrCreate(
            ['name' => 'customer-view'],
            [
                'display_name' => 'View Customer',
                'description' => 'Grant View Customer'
            ]);

        $customerCreate = Permission::updateOrCreate(
            ['name' => 'customer-create'],
            [
                'display_name' => 'Create Customer',
                'description' => 'Grant Create Customer'
            ]);

        $customerEdit = Permission::updateOrCreate(
            ['name' => 'customer-edit'],
            [
                'display_name' => 'Edit Customer',
                'description' => 'Grant Edit Customer'
            ]);

        $customerDelete = Permission::updateOrCreate(
            ['name' => 'customer-delete'],
            [
                'display_name' => 'Delete Customer',
                'description' => 'Grant Delete Customer'
            ]);

        $customerDivide = Permission::updateOrCreate(
            ['name' => 'customer-divide'],
            [
                'display_name' => 'Divide Customer',
                'description' => 'Grant Divide Customer'
            ]);

        $customerCare = Permission::updateOrCreate(
            ['name' => 'customer-care'],
            [
                'display_name' => 'Care Customer',
                'description' => 'Grant Care Customer',
            ]);

        // system perms
        $systemDelete = Permission::updateOrCreate(
            ['name' => 'system-delete'],
            [
                'display_name' => 'Delete System',
                'description' => 'Grant Delete System'
            ]);

        $systemCreate = Permission::updateOrCreate(
            ['name' => 'system-create'],
            [
                'display_name' => 'Create System',
                'description' => 'Grant Create System',
            ]
        );

        $systemEdit = Permission::updateOrCreate(
            ['name' => 'system-edit'],
            [
                'display_name' => 'Edit System',
                'description' => 'Grant Edit System',
            ]
        );

        $systemView = Permission::updateOrCreate(
            ['name' => 'system-view'],
            [
                'display_name' => 'View System',
                'description' => 'Grant View System',
            ]
        );

        // course
        $courseViewPermission = Permission::updateOrCreate(
            [
                'name' => 'course-view',
            ],
            [
                'display_name' => 'View Course',
                'description' => 'View Course',
            ]);

        $courseCreatePermission = Permission::updateOrCreate(
            [
                'name' => 'course-create',
            ],
            [
                'display_name' => 'Create Course',
                'description' => 'Create Course',
            ]);

        $courseEditPermission = Permission::updateOrCreate(
            [
                'name' => 'course-edit',
            ],
            [
                'display_name' => 'Edit Course',
                'description' => 'Edit Course',
            ]);

        $courseDeletePermission = Permission::updateOrCreate(
            [
                'name' => 'course-delete',
            ],
            [
                'display_name' => 'Delete Course',
                'description' => 'Delete Course',
            ]
        );


        // price
        $priceViewPermission = Permission::updateOrCreate(
            ['name' => 'price-view'],
            [
                'display_name' => 'View Price',
                'description' => 'View Price'
            ]
        );

        $priceCreatePermission = Permission::updateOrCreate(
            ['name' => 'price-create'],
            [
                'display_name' => 'Create Price',
                'description' => 'Create Price'
            ]
        );

        $priceEditPermission = Permission::updateOrCreate(
            ['name' => 'price-edit'],
            [
                'display_name' => 'Edit Price',
                'description' => 'Edit Price'
            ]
        );

        $priceDeletePermission = Permission::updateOrCreate(
            ['name' => 'price-delete'],
            [
                'display_name' => 'Delete Price',
                'description' => 'Delete Price',
            ]
        );

        // conversation
        $conversationViewPermission = Permission::updateOrCreate(
            ['name' => 'conversation-view'],
            [
                'display_name' => 'View Conversation',
                'description' => 'View conversation'
            ]
        );

        $conversationCreatePermission = Permission::updateOrCreate(
            ['name' => 'conversation-create'],
            [
                'display_name' => 'Create Conversation',
                'description' => 'Create conversation'
            ]
        );

        $conversationEditPermission = Permission::updateOrCreate(
            ['name' => 'conversation-edit'],
            [
                'display_name' => 'Edit Conversation',
                'description' => 'Edit conversation'
            ]
        );

        $conversationDeletePermission = Permission::updateOrCreate(
            ['name' => 'conversation-delete'],
            [
                'display_name' => 'Delete Conversation',
                'description' => 'Delete conversation',
            ]
        );

        $conversationBroadcastPermission = Permission::updateOrCreate(
            ['name' => 'conversation-broadcast'],
            [
                'display_name' => 'Broadcast Conversation',
                'description' => 'Broadcast conversation',
            ]
        );

        //claim request

        $claimRequestViewPermission = Permission::updateOrCreate(
            ['name' => 'claim-request-view'],
            [
                'display_name' => 'View Claim Request',
                'description' => 'View claim request'
            ]
        );

        $claimRequestCreatePermission = Permission::updateOrCreate(
            ['name' => 'claim-request-create'],
            [
                'display_name' => 'Create Claim Request',
                'description' => 'Create claim request'
            ]
        );

        $claimRequestEditPermission = Permission::updateOrCreate(
            ['name' => 'claim-request-edit'],
            [
                'display_name' => 'Edit Claim Request',
                'description' => 'Edit claim request'
            ]
        );

        $claimRequestDeletePermission = Permission::updateOrCreate(
            ['name' => 'claim-request-delete'],
            [
                'display_name' => 'Delete Claim Request',
                'description' => 'Delete claim request',
            ]
        );

        // faq
        $faqView = Permission::updateOrCreate(
            ['name' => 'faq-view'],
            [
                'display_name' => 'View FAQ',
                'description' => 'Grant View FAQ'
            ]);

        $faqCreate = Permission::updateOrCreate(
            ['name' => 'faq-create'],
            [
                'display_name' => 'Create FAQ',
                'description' => 'Grant Create FAQ',
            ]
        );

        $faqEdit = Permission::updateOrCreate(
            ['name' => 'faq-edit'],
            [
                'display_name' => 'Edit FAQ',
                'description' => 'Grant Edit FAQ',
            ]
        );

        $faqDelete = Permission::updateOrCreate(
            ['name' => 'faq-delete'],
            [
                'display_name' => 'Delete FAQ',
                'description' => 'Grant Delete FAQ'
            ]);

        // faq topic
        $faqTopicView = Permission::updateOrCreate(
            ['name' => 'faq-topic-view'],
            [
                'display_name' => 'View FAQ Topic',
                'description' => 'Grant View FAQ Topic'
            ]);

        $faqTopicCreate = Permission::updateOrCreate(
            ['name' => 'faq-topic-create'],
            [
                'display_name' => 'Create FAQ Topic',
                'description' => 'Grant Create FAQ Topic',
            ]
        );

        $faqTopicEdit = Permission::updateOrCreate(
            ['name' => 'faq-topic-edit'],
            [
                'display_name' => 'Edit FAQ Topic',
                'description' => 'Grant Edit FAQ Topic',
            ]
        );

        $faqTopicDelete = Permission::updateOrCreate(
            ['name' => 'faq-topic-delete'],
            [
                'display_name' => 'Delete FAQ Topic',
                'description' => 'Grant Delete FAQ Topic'
            ]);

        $contactUsView = Permission::updateOrCreate(
            ['name' => 'contact-us-view'],
            [
                'display_name' => 'View Contact Us',
                'description' => 'Grant View Contact Us'
            ]);

        // accounting
        $incomeView = Permission::updateOrCreate(
            ['name' => 'income-view'],
            [
                'display_name' => 'View Income Report',
                'description' => 'Grant View Income Report'
            ]);

        $outcomeView = Permission::updateOrCreate(
            ['name' => 'outcome-view'],
            [
                'display_name' => 'View Outcome Report',
                'description' => 'Grant View Outcome Report'
            ]);

        // teacher salary term perms
        $teacherSalaryTermDelete = Permission::updateOrCreate(
            ['name' => 'teacher-salary-term-delete'],
            [
                'display_name' => 'Delete Teacher Salary Term',
                'description' => 'Grant Delete Teacher Salary Term'
            ]);

        $teacherSalaryTermCreate = Permission::updateOrCreate(
            ['name' => 'teacher-salary-term-create'],
            [
                'display_name' => 'Create Teacher Salary Term',
                'description' => 'Grant Create Teacher Salary Term',
            ]
        );

        $teacherSalaryTermEdit = Permission::updateOrCreate(
            ['name' => 'teacher-salary-term-edit'],
            [
                'display_name' => 'Edit Teacher Salary Term',
                'description' => 'Grant Edit Teacher Salary Term',
            ]
        );

        $teacherSalaryTermView = Permission::updateOrCreate(
            ['name' => 'teacher-salary-term-view'],
            [
                'display_name' => 'View Teacher Salary Term',
                'description' => 'Grant View Teacher Salary Term',
            ]
        );

        // handle session
        $sessionHandle = Permission::updateOrCreate(
            ['name' => 'session-handle'],
            [
                'display_name' => 'Handle Session',
                'description' => 'Grant Handle Session',
            ]
        );

        //  review teacher permisson
        $reviewTeacherViewPermission = Permission::updateOrCreate(
            ['name' => 'review-teacher-view'],
            [
                'display_name' => 'View Review Teacher',
                'description' => 'View Review Teacher'
            ]
        );

        $reviewTeacherCreatePermission = Permission::updateOrCreate(
            ['name' => 'review-teacher-create'],
            [
                'display_name' => 'Create Review Teacher',
                'description' => 'Create Review Teacher'
            ]
        );

        $reviewTeacherEditPermission = Permission::updateOrCreate(
            ['name' => 'review-teacher-edit'],
            [
                'display_name' => 'Edit Review Teacher',
                'description' => 'Edit Review Teacher'
            ]
        );

        $reviewTeacherDeletePermission = Permission::updateOrCreate(
            ['name' => 'review-teacher-delete'],
            [
                'display_name' => 'Delete Review Teacher',
                'description' => 'Delete Review Teacher'
            ]
        );

        $reviewTeacherExportPermission = Permission::updateOrCreate(
            ['name' => 'review-teacher-export'],
            [
                'display_name' => 'Export Review Teacher',
                'description' => 'Export Review Teacher'
            ]
        );

        //  review student permisson
        $reviewStudentViewPermission = Permission::updateOrCreate(
            ['name' => 'review-student-view'],
            [
                'display_name' => 'View Review Student',
                'description' => 'View Review Student'
            ]
        );

        $reviewStudentCreatePermission = Permission::updateOrCreate(
            ['name' => 'review-student-create'],
            [
                'display_name' => 'Create Review Student',
                'description' => 'Create Review Student'
            ]
        );

        $reviewStudentEditPermission = Permission::updateOrCreate(
            ['name' => 'review-student-edit'],
            [
                'display_name' => 'Edit Review Student',
                'description' => 'Edit Review Student'
            ]
        );

        $reviewStudentDeletePermission = Permission::updateOrCreate(
            ['name' => 'review-student-delete'],
            [
                'display_name' => 'Delete Review Student',
                'description' => 'Delete Review Student'
            ]
        );

        $reviewStudentExportPermission = Permission::updateOrCreate(
            ['name' => 'review-student-export'],
            [
                'display_name' => 'Export Review Student',
                'description' => 'Export Review Student'
            ]
        );

        //  review cmd permisson
        $reviewCmdViewPermission = Permission::updateOrCreate(
            ['name' => 'review-cmd-view'],
            [
                'display_name' => 'View Review CMD',
                'description' => 'View Review CMD'
            ]
        );

        $reviewCmdCreatePermission = Permission::updateOrCreate(
            ['name' => 'review-cmd-create'],
            [
                'display_name' => 'Create Review CMD',
                'description' => 'Create Review CMD'
            ]
        );

        $reviewCmdEditPermission = Permission::updateOrCreate(
            ['name' => 'review-cmd-edit'],
            [
                'display_name' => 'Edit Review CMD',
                'description' => 'Edit Review CMD'
            ]
        );

        $reviewCmdDeletePermission = Permission::updateOrCreate(
            ['name' => 'review-cmd-delete'],
            [
                'display_name' => 'Delete Review CMD',
                'description' => 'Delete Review CMD'
            ]
        );

        $reviewCmdExportPermission = Permission::updateOrCreate(
            ['name' => 'review-cmd-export'],
            [
                'display_name' => 'Export Review CMD',
                'description' => 'Export Review CMD'
            ]
        );

        $teacherExportPermission = Permission::updateOrCreate(
            ['name' => 'teacher-export'],
            [
                'display_name' => 'Export Teacher',
                'description' => 'Export Teacher'
            ]
        );

        $teacherRequestExportPermission = Permission::updateOrCreate(
            ['name' => 'teacher-request-export'],
            [
                'display_name' => 'Export Teacher Request',
                'description' => 'Export Teacher Request'
            ]
        );

        $studentExportPermission = Permission::updateOrCreate(
            ['name' => 'student-export'],
            [
                'display_name' => 'Export Student',
                'description' => 'Export Student'
            ]
        );

        $contactExportPermission = Permission::updateOrCreate(
            ['name' => 'contact-export'],
            [
                'display_name' => 'Export Contact',
                'description' => 'Export Contact'
            ]
        );

        $courseExportPermission = Permission::updateOrCreate(
            ['name' => 'course-export'],
            [
                'display_name' => 'Export Course',
                'description' => 'Export Course'
            ]
        );

        //--------------------
        // user roles
        $userManagerRole = Role::updateOrCreate(
            ['name' => 'user_manager'],
            [
                'display_name' => 'User manager',
                'description' => 'User managerment',
            ]
        );

        $userViewerRole = Role::updateOrCreate(
            ['name' => 'user_viewer'],
            [
                'display_name' => 'User Viewer',
                'description' => 'User Viewer',
            ]
        );

        // teacher roles
        $teacherManagerRole = Role::updateOrCreate(
            ['name' => 'teacher_manager'],
            [
                'display_name' => 'Teacher manager',
                'description' => 'Teacher managerment',
            ]
        );

        $teacherViewerRole = Role::updateOrCreate(
            ['name' => 'teacher_viewer'],
            [
                'display_name' => 'Teacher Viewer',
                'description' => 'Teacher Viewer',
            ]
        );

        $teacherMessageBroadcastRole = Role::updateOrCreate(
            ['name' => 'teacher_message_broadcaster'],
            [
                'display_name' => 'Teacher Message Broadcast',
                'description' => 'Teacher message broadcast',
            ]
        );

        $teacherTrainerRole = Role::updateOrCreate(
            ['name' => 'teacher_trainer'],
            [
                'display_name' => 'Teacher Trainer',
                'description' => 'Teacher Trainer',
            ]
        );

        // student roles
        $studentManagerRole = Role::updateOrCreate(
            ['name' => 'student_manager'],
            [
                'display_name' => 'Student Manager',
                'description' => 'Student manager',
            ]
        );

        $studentViewerRole = Role::updateOrCreate(
            ['name' => 'student_viewer'],
            [
                'display_name' => 'Student Viewer',
                'description' => 'Student viewer',
            ]
        );

        // role roles
        $roleManagerRole = Role::updateOrCreate(
            ['name' => 'role_manager'],
            [
                'display_name' => 'Role Manager',
                'description' => 'Role manager',
            ]
        );

        $roleViewerRole = Role::updateOrCreate(
            ['name' => 'role_viewer'],
            [
                'display_name' => 'Role Viewer',
                'description' => 'Role viewer',
            ]
        );

        // meta roles
        $metaManagerRole = Role::updateOrCreate(
            ['name' => 'meta_manager'],
            [
                'display_name' => 'Meta Manager',
                'description' => 'Meta manager',
            ]
        );

        $metaViewerRole = Role::updateOrCreate(
            ['name' => 'meta_viewer'],
            [
                'display_name' => 'Meta Viewer',
                'description' => 'Meta viewer',
            ]
        );

        // meta roles
        $teamManagerRole = Role::updateOrCreate(
            ['name' => 'team_manager'],
            [
                'display_name' => 'Team Manager',
                'description' => 'Team manager',
            ]
        );

        $teamViewerRole = Role::updateOrCreate(
            ['name' => 'team_viewer'],
            [
                'display_name' => 'Team Viewer',
                'description' => 'Team viewer',
            ]
        );

        // learning request roles
        $learningRequestManagerRole = Role::updateOrCreate(
            ['name' => 'learning_request_manager'],
            [
                'display_name' => 'Learning Request Manager',
                'description' => 'Learning request manager',
            ]
        );

        $learningRequestViewerRole = Role::updateOrCreate(
            ['name' => 'learning_request_viewer'],
            [
                'display_name' => 'Learning Request Viewer',
                'description' => 'Learning request viewer',
            ]
        );

        // contact role
        $contactManagerRole = Role::updateOrCreate(
            ['name' => 'contact_manager'],
            [
                'display_name' => 'Contact Manager',
                'description' => 'Contact manager',
            ]
        );

        $contactViewerRole = Role::updateOrCreate(
            ['name' => 'contact_viewer'],
            [
                'display_name' => 'Contact Viewer',
                'description' => 'Contact viewer',
            ]
        );

        $contactCarerRole = Role::updateOrCreate(
            ['name' => 'contact_carer'],
            [
                'display_name' => 'Contact Carer',
                'description' => 'Contact carer',
            ]);

        // customer role
        $customerManagerRole = Role::updateOrCreate(
            ['name' => 'customer_manager'],
            [
                'display_name' => 'Customer Manager',
                'description' => 'Customer manager',
            ]
        );

        $customerViewerRole = Role::updateOrCreate(
            ['name' => 'customer_viewer'],
            [
                'display_name' => 'Customer Viewer',
                'description' => 'Customer viewer',
            ]
        );

        $customerCarerRole = Role::updateOrCreate(
            ['name' => 'customer_carer'],
            [
                'display_name' => 'Customer Carer',
                'description' => 'Customer carer',
            ]);

        // system roles
        $systemManagerRole = Role::updateOrCreate(
            ['name' => 'system_manager'],
            [
                'display_name' => 'System manager',
                'description' => 'System managerment',
            ]
        );

        $systemViewerRole = Role::updateOrCreate(
            ['name' => 'system_viewer'],
            [
                'display_name' => 'System Viewer',
                'description' => 'System Viewer',
            ]
        );

        // course
        $courseManagerRole = Role::updateOrCreate(
            [
                'name' => 'course_manager',
            ],
            [
                'display_name' => 'Course Manager',
                'description' => 'Course Manager',
            ]);

        $courseViewerRole = Role::updateOrCreate(
            [
                'name' => 'course_viewer',
            ],
            [
                'display_name' => 'Course Viewer',
                'description' => 'Course Viewer',
            ]);

        // conversation
        $conversationViewerRole = Role::updateOrCreate(
            ['name' => 'conversation_viewer'],
            [
                'display_name' => 'Conversation Viewer',
                'description' => 'Conversation Viewer',
            ]
        );

        $conversationManagerRole = Role::updateOrCreate(
            ['name' => 'conversation_manager'],
            [
                'display_name' => 'Conversation Manager',
                'description' => 'Conversation Manager',
            ]
        );

        $conversationBroadcasterRole = Role::updateOrCreate(
            ['name' => 'conversation_broadcaster'],
            [
                'display_name' => 'Conversation Broadcaster',
                'description' => 'Conversation Broadcaster',
            ]
        );

        // claim request
        $claimRequestViewerRole = Role::updateOrCreate(
            ['name' => 'claim_request_viewer'],
            [
                'display_name' => 'Claim Request Viewer',
                'description' => 'Claim Request Viewer',
            ]
        );

        $claimRequestManagerRole = Role::updateOrCreate(
            ['name' => 'claim_request_manager'],
            [
                'display_name' => 'Claim Request Manager',
                'description' => 'Claim Request Manager',
            ]
        );

        // price
        $priceViewerRole = Role::updateOrCreate(
            ['name' => 'price_viewer'],
            [
                'display_name' => 'Price Viewer',
                'description' => 'Price Viewer',
                'status' => Role::STATUS_HIDDEN
            ]
        );

        $priceManagerRole = Role::updateOrCreate(
            ['name' => 'price_manager'],
            [
                'display_name' => 'Price Manager',
                'description' => 'Price Manager',
                'status' => Role::STATUS_HIDDEN
            ]
        );

        // faq
        $faqManagerRole = Role::updateOrCreate(
            ['name' => 'faq_manager'],
            [
                'display_name' => 'FAQ Manager',
                'description' => 'FAQ manager',
            ]
        );

        $faqViewerRole = Role::updateOrCreate(
            ['name' => 'faq_viewer'],
            [
                'display_name' => 'FAQ Viewer',
                'description' => 'FAQ viewer',
            ]
        );

        // faq topic
        $faqTopicManagerRole = Role::updateOrCreate(
            ['name' => 'faq_topic_manager'],
            [
                'display_name' => 'FAQ Topic Manager',
                'description' => 'FAQ topic manager',
            ]
        );

        $faqTopicViewerRole = Role::updateOrCreate(
            ['name' => 'faq_topic_viewer'],
            [
                'display_name' => 'FAQ Topic Viewer',
                'description' => 'FAQ topic viewer',
            ]
        );

        // contact
        $contactUsManagerRole = Role::updateOrCreate(
            ['name' => 'contact_us_manager'],
            [
                'display_name' => 'Contact-Us Manager',
                'description' => 'Contact-Us Manager',
            ]
        );

        // accounting
        $accountingManagerRole = Role::updateOrCreate(
            ['name' => 'accounting_manager'],
            [
                'display_name' => 'Accounting Manager',
                'description' => 'Accounting Manager',
            ]
        );

        // teacher salary term roles
        $teacherSalaryTermManagerRole = Role::updateOrCreate(
            ['name' => 'teacher_salary_term_manager'],
            [
                'display_name' => 'Teacher Salary Term Manager',
                'description' => 'Teacher Salary Term Manager',
            ]
        );

        $teacherSalaryTermViewerRole = Role::updateOrCreate(
            ['name' => 'teacher_salary_term_viewer'],
            [
                'display_name' => 'Teacher Salary Term Viewer',
                'description' => 'Teacher Salary Term Viewer',
            ]
        );

        $teacherReviewManagerRole = Role::updateOrCreate(
            ['name' => 'teacher_review_manager'],
            [
                'display_name' => 'Teacher Review Manager',
                'description' => 'Teacher Review Manager',
                'status' => Role::STATUS_HIDDEN
            ]
        );

        $studentReviewManagerRole = Role::updateOrCreate(
            ['name' => 'student_review_manager'],
            [
                'display_name' => 'Student Review Manager',
                'description' => 'Student Review Manager',
                'status' => Role::STATUS_HIDDEN
            ]
        );

        $cmdReviewManagerRole = Role::updateOrCreate(
            ['name' => 'cmd_review_manager'],
            [
                'display_name' => 'CMD Review Manager',
                'description' => 'CMD Review Manager',
                'status' => Role::STATUS_HIDDEN
            ]
        );

        //--------------------------
        // user role perms
        $userManagerRole->perms()->attach([
            $userCreate->id,
            $userEdit->id,
            $userDelete->id,
            $userView->id,
        ]);

        $userViewerRole->perms()->attach([
            $userView->id,
        ]);

        // teacher role perms
        $teacherManagerRole->perms()->attach([
            $teacherCreate->id,
            $teacherEdit->id,
            $teacherDelete->id,
            $teacherView->id,

            $teacherRecruit->id,
            $teacherInterview->id,

            $teacherExportPermission->id,
            $teacherRequestExportPermission->id,
        ]);

        $teacherViewerRole->perms()->attach([
            $teacherView->id,
        ]);

        $teacherMessageBroadcastRole->attachPermission([
            $teacherMessageBroadcastPermission,
        ]);

        $teacherTrainerRole->attachPermission([
            $teacherTrainPermission,
        ]);

        // student role perms
        $studentManagerRole->perms()->attach([
            $studentCreate->id,
            $studentEdit->id,
            $studentDelete->id,
            $studentView->id,

            $studentExportPermission->id,
        ]);

        $studentViewerRole->perms()->attach([
            $studentView->id,
        ]);

        // role role perms
        $roleManagerRole->perms()->attach([
            $roleCreate->id,
            $roleEdit->id,
            $roleDelete->id,
            $roleView->id,
        ]);

        $roleViewerRole->perms()->attach([
            $roleView->id,
        ]);

        // meta role perms
        $metaManagerRole->perms()->attach([
            $metaCreate->id,
            $metaEdit->id,
            $metaDelete->id,
            $metaView->id,
        ]);

        $metaViewerRole->perms()->attach([
            $metaView->id,
        ]);

        // team role perms
        $teamManagerRole->perms()->attach([
            $teamCreate->id,
            $teamEdit->id,
            $teamDelete->id,
            $teamView->id,
        ]);

        $teamViewerRole->perms()->attach([
            $teamView->id,
        ]);

        // learning request role perms
        $learningRequestManagerRole->perms()->attach([
            $learningRequestCreate->id,
            $learningRequestEdit->id,
            $learningRequestDelete->id,
            $learningRequestView->id,

            $learningRequestConvert->id,
        ]);

        $learningRequestViewerRole->perms()->attach([
            $learningRequestView->id,
        ]);

        // contact role perms
        $contactManagerRole->perms()->attach([
            $contactCreate->id,
            $contactEdit->id,
            $contactDelete->id,
            $contactView->id,

            $contactResolve->id,
            $contactDivide->id,
            $contactTeamReportPermission->id,

            $contactExportPermission->id,
        ]);

        $contactViewerRole->perms()->attach([
            $contactView->id,
        ]);

        $contactCarerRole->perms()->attach([
            $contactView->id,
            $contactCare->id,
        ]);

        // customer role perms
        $customerManagerRole->perms()->attach([
            $customerCreate->id,
            $customerEdit->id,
            $customerDelete->id,
            $customerView->id,

            $customerDivide->id,
        ]);

        $customerViewerRole->perms()->attach([
            $customerView->id,
        ]);

        $customerCarerRole->perms()->attach([
            $customerView->id,
            $customerCare->id,
        ]);

        // system role perms
        $systemManagerRole->perms()->attach([
            $systemCreate->id,
            $systemEdit->id,
            $systemDelete->id,
            $systemView->id,
        ]);

        $systemViewerRole->perms()->attach([
            $systemView->id,
        ]);

        // course
        $courseManagerRole->perms()->attach([
            $courseCreatePermission->id,
            $courseEditPermission->id,
            $courseDeletePermission->id,
            $courseViewPermission->id,

            $sessionHandle->id,
            $courseExportPermission->id,
        ]);

        $courseViewerRole->perms()->attach([
            $courseViewPermission->id,
        ]);

        // conversation
        $conversationManagerRole->attachPermission([
            $conversationCreatePermission,
            $conversationEditPermission,
            $conversationDeletePermission,
            $conversationViewPermission,
            $conversationBroadcastPermission,
        ]);

        $conversationViewerRole->attachPermission([
            $conversationViewPermission,
        ]);

        $conversationBroadcasterRole->attachPermission([
            $conversationBroadcastPermission,
        ]);

        // claim request
        $claimRequestManagerRole->attachPermission([
            $claimRequestCreatePermission,
            $claimRequestEditPermission,
            $claimRequestDeletePermission,
            $claimRequestViewPermission,
        ]);

        $claimRequestViewerRole->attachPermission([
            $claimRequestViewPermission,
        ]);

        // price
        $priceManagerRole->attachPermission([
            $priceViewPermission,
            $priceCreatePermission,
            $priceEditPermission,
            $priceDeletePermission
        ]);

        $priceViewerRole->attachPermission($priceViewPermission);

        $faqManagerRole->perms()->attach([
            $faqView->id,
            $faqCreate->id,
            $faqEdit->id,
            $faqDelete->id,
        ]);

        $faqViewerRole->perms()->attach([
            $faqView->id,
        ]);

        $faqTopicManagerRole->perms()->attach([
            $faqTopicView->id,
            $faqTopicCreate->id,
            $faqTopicEdit->id,
            $faqTopicDelete->id,
        ]);

        $faqTopicViewerRole->perms()->attach([
            $faqTopicView->id,
        ]);

        $contactUsManagerRole->perms()->attach([
            $contactUsView->id,
        ]);

        $accountingManagerRole->perms()->attach([
            $incomeView->id,
            $outcomeView->id,
        ]);

        $teacherReviewManagerRole->attachPermission([
            $reviewTeacherViewPermission,
            $reviewTeacherCreatePermission,
            $reviewTeacherEditPermission,
            $reviewTeacherDeletePermission,
            $reviewTeacherExportPermission,
        ]);

        $studentReviewManagerRole->attachPermission([
            $reviewStudentViewPermission,
            $reviewStudentCreatePermission,
            $reviewStudentEditPermission,
            $reviewStudentDeletePermission,
            $reviewStudentExportPermission,
        ]);

        $cmdReviewManagerRole->attachPermission([
            $reviewCmdViewPermission,
            $reviewCmdCreatePermission,
            $reviewCmdEditPermission,
            $reviewCmdDeletePermission,
            $reviewCmdExportPermission,
        ]);
        //----------------


        // -------
        $user = User::where('email', '=', 'admin@antoree.com')->first();
        if ($user) {
            $user->roles()->attach([
                $userManagerRole->id,
                $teacherManagerRole->id,
                $teacherMessageBroadcastRole->id,
                $teacherTrainerRole->id,
                $studentManagerRole->id,
                $roleManagerRole->id,
                $metaManagerRole->id,
                $teamManagerRole->id,
                $learningRequestManagerRole->id,
                $contactManagerRole->id,
                $customerManagerRole->id,
                $systemManagerRole->id,
                $courseManagerRole->id,
                $conversationManagerRole->id,
                $claimRequestManagerRole->id,
                $priceManagerRole->id,
                $faqManagerRole->id,
                $faqTopicManagerRole->id,
                $contactUsManagerRole->id,
                $accountingManagerRole->id,
                $teacherSalaryTermManagerRole->id,
                $teacherReviewManagerRole->id,
                $studentReviewManagerRole->id,
                $cmdReviewManagerRole->id,
            ]);
        }
    }
}
