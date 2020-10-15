# Base

[Katniss](https://github.com/linhntaim/katniss)

## Installation

```
composer install
php artisan passport:keys
```

## Generate syncing data

```
truncate table sys_sync_live;
insert into sys_sync_live (`table`,`type`,`value`)
select 'roles',1,id from roles
union
select 'permissions',1,id from permissions
union
select 'permissions_roles',1,concat(permission_id, '-', role_id) from permission_role
union
select 'users',1,id from users
union
select 'roles_users',1,concat(role_id, '-', user_id) from role_user
union
select 'teachers',1,id from teachers
union
select 'students',1,id from students
union
select 'topics',1,id from topics
union
select 'topic_translations',1,id from topic_translations
union
select 'capabilities',1,id from capabilities
union
select 'tags',1,id from tags
union
select 'courses',1,id from courses
union
select 'lessons',1,id from lessons
union
select 'working_fields',1,id from working_fields
union
select 'working_field_translations',1,id from working_fields_translations
union
select 'users_working_fields',1,concat(user_id, '-', fields_id) from working_fields_users
union
select 'teacher_target_topics',1,concat(teacher_id, '-', topic_id) from topics_teachers
union 
select 'tmp_learning_requests',1,id from tmp_learning_requests
union
select 'charge_history',1,id from charges_history
union
select 'claim_requests',1,id from claim_requests
union
select 'claim_requests_topics',1,concat(request_id, '-', topic_id) from topics_requests
union
select 'claim_responses',1,concat(teacher_id, '-', request_id) from teachers_requests
union
select 'user_educations',1,id from user_educations
union
select 'user_works',1,id from user_works
union
select 'teacher_salary_rates',1,id from rates_history
union
select 'course_aborts',1,id from course_end
union
select 'claim_teacher_groups',1,concat(request_id, '-', channel_id) from channels_requests
union
select 'reviews',1,id from reviews
union
select 'teachers_reviews',1,concat(teacher_id, '-', review_id) from teacher_reviews
union
select 'payslips',1,id from payslips
union
select 'payslip_details',1,id from payslip_details
union
select 'payslip_details_courses',1,concat(detail_id, '-', course_id) from payslipdetails_courses
union
select 'issues',1,id from problem_course
union
select 'course_informs',1,id from report_delay
union
select 'payment_info',1,id from payments_info
union
select 'user_referrals',1,id from referrals
union
select 'teacher_available_times',1,user_id from hour_day
```

```
DELETE
FROM `sys_sync`
where `table` not in (
'roles', 
'permissions', 
'permissions_roles', 
'users', 
'roles_users', 
'teachers', 
'students',
'topics',
'topic_translations',
'capabilities',
'tags',
'courses',
'lessons',
'working_fields',
'working_field_translations',
'users_working_fields',
'teacher_target_topics',
'tmp_learning_requests',
'charge_history',
'claim_requests',
'claim_requests_topics',
'claim_responses',
'user_educations',
'user_works',
'teacher_salary_rates',
'course_aborts',
'claim_teacher_groups',
'reviews',
'teachers_reviews',
'payslips',
'payslip_details',
'payslip_details_courses',
'issues',
'course_informs',
'payment_info',
'user_referrals',
'teacher_available_times'
);
insert into sys_sync (`table`,`type`,`value`)
```

```
insert into an_roles_users (role_id, user_id)
select 5,user_id 
from an_teachers 
where user_id not in (select user_id from an_roles_users where role_id=5);
insert into an_roles_users (role_id, user_id)
select 6,user_id 
from an_students 
where user_id not in (select user_id from an_roles_users where role_id=6);
```# demo-gate
