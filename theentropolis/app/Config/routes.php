<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
//Router::connect('/', array('controller' => 'pages', 'action' => 'index'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

//Router::connect('/admin', array('admin' => true, 'controller' => 'users', 'action' => 'login')); default
Router::connect('/', array('admin' => true, 'controller' => 'users', 'action' => 'login'));
Router::connect('/start-here', array('controller' => 'tourVideos','action'=>'index'));
Router::connect('/start-here/view', array('controller' => 'tourVideos','action'=>'view'));
Router::connect('/start-here/edit/*', array('controller' => 'tourVideos', 'action'=>'edit'));
Router::connect('/start-here/add/*', array('controller' => 'tourVideos', 'action'=>'add'));

Router::connect('/hq-dashboard', array('controller' => 'advices', 'action' => 'dashboard'));
Router::connect('/kc-teacher-dashboard', array('controller' => 'advices', 'action' => 'teacher_dashboard'));
Router::connect('/knowledge-bank', array('controller' => 'wisdoms', 'action' => 'index'));
Router::connect('/knowledge-bank/educator-experience', array('controller' => 'advices', 'action' => 'index'));
Router::connect('/knowledge-bank/mentor-advice', array('controller' => 'decisionBanks', 'action' => 'index'));
Router::connect('/knowledge-bank/entropolis-curated', array('controller' => 'expertAdvices', 'action' => 'adviceList'));
Router::connect('/knowledge-bank/favourites', array('controller' => 'myLibrarys', 'action' => 'index'));
Router::connect('/ask-for-advice', array('controller' => 'askQuestions', 'action' => 'index'));
Router::connect('/directory', array('controller' => 'credStreets', 'action' => 'index'));
//Router::connect('/hq-blog', array('controller' => 'blogs', 'action' => 'add'));
Router::connect('/account-settings', array('controller' => 'users', 'action' => 'profile'));
Router::connect('/settings/edit', array('controller' => 'users', 'action' => 'settings'));
// Router::connect('/account-settings/edit', array('controller' => 'users', 'action' => 'profile'));
Router::connect('/Tutorials', array('controller' => 'cityGuides', 'action' => 'index'));
Router::connect('/Tutorials/edit', array('controller' => 'cityGuides', 'action' => 'edit'));
Router::connect('/term-use', array('controller' => 'pages', 'action' => 'termUse'));

Router::connect('/club-kidpreneur', array('controller' => 'pages', 'action' => 'clubKidpreneur'));
Router::connect('/trepicentre', array('controller' => 'pages', 'action' => 'error'));
Router::connect('/academy', array('controller' => 'pages', 'action' => 'error'));

Router::connect('/support-peeps', array('controller' => 'pages', 'action' => 'supportPeeps'));

Router::connect('/ck-hero-school', array('controller' => 'pages', 'action' => 'ckheroschool'));
Router::connect('/kidpreneur-challenge', array('controller' => 'pages', 'action' => 'challenge'));
Router::connect('/ck-girl-boss', array('controller' => 'pages', 'action' => 'ckGirlsTheBoss'));
Router::connect('/ap-kids', array('controller' => 'pages', 'action' => 'ckAngelPitchKidpreneurs'));
Router::connect('/ck-budding-business-brains', array('controller' => 'pages', 'action' => 'ckBuddingBusinessBrains'));
Router::connect('/ck-education', array('controller' => 'pages', 'action' => 'ckEducation'));
Router::connect('/ck-entrepreneurs-future', array('controller' => 'pages', 'action' => 'ckEntrepreneursOfTheFuture'));
Router::connect('/cancel', array('controller' => 'pages', 'action' => 'cancel'));
Router::connect('/KidChall-Toolkit', array('controller' => 'toolkits', 'action' => 'index'));
Router::connect('/KidChall-Toolkit/edit', array('controller' => 'toolkits', 'action' => 'edit'));

Router::connect('/KidChallE-Toolkit', array('controller' => 'teachertoolkits', 'action' => 'index'));
Router::connect('/KidChallE-Toolkit/edit', array('controller' => 'teachertoolkits', 'action' => 'edit'));

Router::connect('/KidChallP-Toolkit', array('controller' => 'parenttoolkits', 'action' => 'index'));
Router::connect('/KidChallP-Toolkit/edit', array('controller' => 'parenttoolkits', 'action' => 'edit'));

Router::connect('/my-biz-toolkit', array('controller' => 'KidpreneurToolkits', 'action' => 'index'));
Router::connect('/my-biz-toolkit/edit', array('controller' => 'KidpreneurToolkits', 'action' => 'edit'));

Router::connect('/parents-dashboard', array('controller' => 'parents', 'action' => 'dashboard'));

// new pages
Router::connect('/parents', array('controller' => 'pages', 'action' => 'parents'));
Router::connect('/educators', array('controller' => 'pages', 'action' => 'educators'));
Router::connect('/heroes', array('controller' => 'pages', 'action' => 'superheros'));
Router::connect('/ninjas', array('controller' => 'pages', 'action' => 'kid_ninja'));
Router::connect('/challenge', array('controller' => 'pages', 'action' => 'kc_schools'));
Router::connect('/media', array('controller' => 'pages', 'action' => 'blog'));
Router::connect('/about-us', array('controller' => 'pages', 'action' => 'aboutus'));

Router::connect('/ask-hq', array('controller' => 'askHqs', 'action' => 'index'));
Router::connect('/kidpreneurs/ask-an-adult', array('controller' => 'AskHqs', 'action' => 'kid_askhq'));
Router::connect('/kidpreneurs/account-settings', array('controller' => 'kidpreneurs', 'action' => 'settings'));

 
 
//Router::connect('/mysuggestion', array('controller' => 'suggestions', 'action' => 'teachersuggestion'));

// The day after tomorrow
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
Router::mapResources('recipes');
Router::parseExtensions();
require CAKE . 'Config' . DS . 'routes.php';
