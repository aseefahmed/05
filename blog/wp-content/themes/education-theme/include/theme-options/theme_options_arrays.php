<?php

global $page_option;

$edu_lms_demo = cs_get_demo_content('edu_lms.json');
$edu_academy_demo = cs_get_demo_content('edu_academy.json');
$edu_coach_demo = cs_get_demo_content('edu_coach.json');
$edu_online_demo = cs_get_demo_content('edu_online.json');
$edu_exams_demo = cs_get_demo_content('edu_exams.json');
$edu_kids_demo = cs_get_demo_content('edu_kids.json');
$edu_skills_demo = cs_get_demo_content('edu_skills.json');
$edu_how_demo = cs_get_demo_content('edu_how.json');
$edu_trainers_demo = cs_get_demo_content('edu_trainers.json');
$edu_kindergarton_demo = cs_get_demo_content('edu_kindergarton.json');
$edu_soft_play_demo = cs_get_demo_content('edu_soft_play.json');
$edu_sunflower_demo = cs_get_demo_content('edu_sunflower.json');
$edu_nursery_demo = cs_get_demo_content('edu_nursery.json');

$page_option[] = array();
$page_option['theme_options'] = array(
    'select' => array(
        'edu_lms' => 'Edu LMS',
        'edu_academy' => 'Edu Academy',
        'edu_coach' => 'Edu Coach',
        'edu_online' => 'Edu Online',
        'edu_exams' => 'Edu Exams',
        'edu_kids' => 'Edu Kids',
        'edu_skills' => 'Edu Skills',
        'edu_how' => 'Edu How',
        'edu_trainers' => 'Edu Trainers',
        'edu_kindergarton' => 'Edu Kindergarton',
        'edu_soft_play' => 'Edu Soft Play',
        'edu_sunflower' => 'Edu Sunflower',
        'edu_nursery' => 'Edu Nursery',
    ),
    'edu_lms' => array(
        'name' => 'Edu LMS',
        'page_slug' => 'edu-lms',
        'theme_option' => $edu_lms_demo,
        'thumb' => '01EduFuture'
    ),
    'edu_academy' => array(
        'name' => 'Edu Academy',
        'page_slug' => 'edu-academy',
        'theme_option' => $edu_academy_demo,
        'thumb' => '02EduLearn'
    ),
    'edu_coach' => array(
        'name' => 'Edu Coach',
        'page_slug' => 'edu-coach',
        'theme_option' => $edu_coach_demo,
        'thumb' => '03EduCoach'
    ),
    'edu_online' => array(
        'name' => 'Edu Online',
        'page_slug' => 'edu-online',
        'theme_option' => $edu_online_demo,
        'thumb' => '04EduOnline'
    ),
    'edu_exams' => array(
        'name' => 'Edu Exams',
        'page_slug' => 'edu-exam',
        'theme_option' => $edu_exams_demo,
        'thumb' => '05EduExams'
    ),
    'edu_how' => array(
        'name' => 'Edu How',
        'page_slug' => 'edu-how',
        'theme_option' => $edu_how_demo,
        'thumb' => '06EduHow'
    ),
    'edu_kids' => array(
        'name' => 'Edu Kids',
        'page_slug' => 'edu-kids',
        'theme_option' => $edu_kids_demo,
        'thumb' => '07EduKids'
    ),
    'edu_kindergarton' => array(
        'name' => 'Edu Kindergarton',
        'page_slug' => 'edu-kindergarten',
        'theme_option' => $edu_kindergarton_demo,
        'thumb' => '08Edukindergarton'
    ),
    'edu_skills' => array(
        'name' => 'Edu Skills',
        'page_slug' => 'edu-skills',
        'theme_option' => $edu_skills_demo,
        'thumb' => '09EduSkills'
    ),
    'edu_trainers' => array(
        'name' => 'Edu Trainers',
        'page_slug' => 'edu-trainers',
        'theme_option' => $edu_trainers_demo,
        'thumb' => '10EduTrainers'
    ),
    'edu_soft_play' => array(
        'name' => 'Edu Soft Play',
        'page_slug' => 'soft-play-house',
        'theme_option' => $edu_soft_play_demo,
        'thumb' => '10EduTrainers'
    ),
    'edu_sunflower' => array(
        'name' => 'Edu Sunflower',
        'page_slug' => 'sun-flower',
        'theme_option' => $edu_sunflower_demo,
        'thumb' => '10EduTrainers'
    ),
    'edu_nursery' => array(
        'name' => 'Edu Nursery',
        'page_slug' => 'colors-nursery',
        'theme_option' => $edu_nursery_demo,
        'thumb' => '10EduTrainers'
    ),
);
