<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/api/v1', function (RouteBuilder $routes) {
    // Register scoped middleware for in scopes.

    // this im comment
    // $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
    //     'httpOnly' => true
    // ]));

    $routes->setExtensions('json');

    /**
     * Apply a middleware to the current route scope.
     * Requires middleware to be registered via `Application::routes()` with `registerMiddleware()`
     */
    // $routes->applyMiddleware('csrf');

    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    // $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    // start my routes
        // $routes->resources('AdminUsers');
        $routes->connect('/show', ['controller' => 'Test', 'action' => 'show']);
        $routes->connect('/test', ['controller' => 'AdminUsers', 'action' => 'test']);
        $routes->connect('/login', ['controller' => 'AdminUsers', 'action' => 'login']);
        $routes->connect('/registration', ['controller' => 'AdminUsers', 'action' => 'registration']);
        $routes->connect('/get_me', ['controller' => 'AdminUsers', 'action' => 'getMe']);
        $routes->connect('/logout', ['controller' => 'AdminUsers', 'action' => 'logout']);
        $routes->connect('/getAdminUsers', ['controller' => 'AdminUsers', 'action' => 'getAdminUsers']);
        $routes->connect('/getEducations', ['controller' => 'Educations', 'action' => 'getEducations']);
        $routes->connect('/verifiedAdminUser', ['controller' => 'AdminUsers', 'action' => 'verifiedAdminUser']);
        $routes->connect('/deleteUser', ['controller' => 'AdminUsers', 'action' => 'deleteUser']);
        $routes->connect('/updateEducation', ['controller' => 'Educations', 'action' => 'updateEducation']);
        $routes->connect('/addEducation', ['controller' => 'Educations', 'action' => 'addEducation']);
        $routes->connect('/deleteEducation', ['controller' => 'Educations', 'action' => 'deleteEducation']);
        $routes->connect('/getFixedDepartaments', ['controller' => 'Educations', 'action' => 'getFixedDepartaments']);
        $routes->connect('/addDepartament', ['controller' => 'Educations', 'action' => 'addDepartament']);
        $routes->connect('/updateDepartament', ['controller' => 'Educations', 'action' => 'updateDepartament']);
        $routes->connect('/deleteDepartament', ['controller' => 'Educations', 'action' => 'deleteDepartament']);
        $routes->connect('/getSpecialtyForIdDepartament', ['controller' => 'Specialty', 'action' => 'getSpecialtyForIdDepartament']);
        $routes->connect('/addSpecialty', ['controller' => 'Specialty', 'action' => 'addSpecialty']);
        $routes->connect('/editSpecialty', ['controller' => 'Specialty', 'action' => 'editSpecialty']);
        $routes->connect('/deleteSpecialty', ['controller' => 'Specialty', 'action' => 'deleteSpecialty']);

        // tickets
        $routes->connect('/getTickets', ['controller' => 'Tickets', 'action' => 'index']);
        $routes->connect('/addTicket', ['controller' => 'Tickets', 'action' => 'addTicket']);
        $routes->connect('/deleteTicket', ['controller' => 'Tickets', 'action' => 'deleteTicket']);
        $routes->connect('/updateTicket', ['controller' => 'Tickets', 'action' => 'updateTicket']);

        // questions
        $routes->connect('/getQuestions', ['controller' => 'Questions', 'action' => 'getQuestions']);
        $routes->connect('/saveQuestion', ['controller' => 'Questions', 'action' => 'saveQuestion']);
        $routes->connect('/deleteQuestion', ['controller' => 'Questions', 'action' => 'deleteQuestion']);
        $routes->connect('/editQuestion', ['controller' => 'Questions', 'action' => 'editQuestion']);

        // answers
        $routes->connect('/searchHash', ['controller' => 'Answers', 'action' => 'searchHash']);
        $routes->connect('/addAnswer', ['controller' => 'Answers', 'action' => 'addAnswer']);
        $routes->connect('/deleteAnswer', ['controller' => 'Answers', 'action' => 'deleteAnswer']);
        $routes->connect('/updateAnswer', ['controller' => 'Answers', 'action' => 'updateAnswer']);
        $routes->connect('/addBundles', ['controller' => 'Answers', 'action' => 'addBundles']);
        $routes->connect('/updateBundle', ['controller' => 'Answers', 'action' => 'updateBundle']);

        // entrants
        $routes->connect('/getEntrants', ['controller' => 'Entrants', 'action' => 'getEntrants']);
        $routes->connect('/addEntrant', ['controller' => 'Entrants', 'action' => 'addEntrant']);
        $routes->connect('/updateEntrant', ['controller' => 'Entrants', 'action' => 'updateEntrant']);
        $routes->connect('/deleteEntrant', ['controller' => 'Entrants', 'action' => 'deleteEntrant']);

        // testing
        $routes->connect('/verificationEntrant', ['controller' => 'Testings', 'action' => 'verificationEntrant']);
        $routes->connect('/getDataAndCheckRootUser', ['controller' => 'Testings', 'action' => 'getDataAndCheckRootUser']);
        $routes->connect('/addAnswerEntant', ['controller' => 'Testings', 'action' => 'addAnswerEntant']);

    // end my routes

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *
     * ```
     * $routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
     * $routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
     * ```
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});

/**
 * If you need a different set of middleware or none at all,
 * open new scope and define routes there.
 *
 * ```
 * Router::scope('/api', function (RouteBuilder $routes) {
 *     // No $routes->applyMiddleware() here.
 *     // Connect API actions here.
 * });
 * ```
 */
