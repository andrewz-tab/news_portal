<?php

use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\CVController as AdminCVController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController as AdminPermissionController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Author\PanelController as AuthorPanelController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CVController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Auth::routes(); 
Route::get('/ban', [HomeController::class, 'ban'])->name('home.ban')->middleware('ban.page');
Route::middleware(['check.ban'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    Route::get('/contacts', [HomeController::class, 'contacts'])->name('home.contacts');
    Route::get('/about', [HomeController::class, 'about'])->name('home.about');

    Route::middleware(['auth'])->group(function () {
        //News
        Route::prefix('/news')->group(function () {
            Route::get('/create/', [PostController::class, 'create'])->name('posts.create');
            Route::post('', [PostController::class, 'store'])->name('posts.store');
            Route::get('/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
            Route::patch('/{post}', [PostController::class, 'update'])->name('posts.update');
            Route::delete('/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
            Route::post('/{postId}/restore', [PostController::class, 'restore'])->name('posts.restore');
            Route::delete('/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
        });

        //Comments
        Route::post('/news/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store');
        Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
        Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
        Route::post('/comments/{commentId}/restore', [CommentController::class, 'restore'])->name('comments.restore');

        //Favourites
        Route::post('/news/{post}/favourite', [FavouriteController::class, 'store'])->name('posts.likes.store');

        //Subscriptions
        Route::post('/author/{author}/subscribe', [SubscriptionController::class, 'store'])->name('subscribe');
        
        //Profile
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
        Route::get('/news/subscriptions', [ProfileController::class, 'news'])->name('profile.news');
        Route::get('/subscription', [ProfileController::class, 'subscriptions'])->name('profile.subscriptions');
        Route::get('/favourites', [ProfileController::class, 'favourites'])->name('profile.favourites');
        Route::patch('/update_password', [ProfileController::class, 'update_password'])->name('profile.password.update');
        Route::patch('/update_general', [ProfileController::class, 'update_general'])->name('profile.general.update');

        //Users
        Route::prefix('/users')->middleware('admin')->group(function () {
            Route::patch('/{user}/update_general', [UserController::class, 'update_general'])->name('users.general.update');
            Route::patch('/{user}/update_roles', [UserController::class, 'update_roles'])->name('users.roles.update');
            Route::delete('/{user}/permissions/{permission}', [UserController::class, 'delete_permission'])->name('users.permissions.destroy');
            Route::delete('/{user}/roles/{role}', [UserController::class, 'delete_role'])->name('users.roles.destroy');
        });

        //Roles
        Route::prefix('/roles')->group(function () {
            Route::delete('/{role}/permission/{permission}', [RoleController::class, 'destroy_permission'])->name('roles.permissions.destroy');
            Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
        });
        //Permissions
        Route::prefix('/permissions')->group(function () {
            Route::patch('/{permission}/roles', [PermissionController::class, 'update'])->name('permissions.roles.update');
            Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
        });
        //CV
        Route::prefix('/cv')->group(function () {
            Route::get('/create', [CVController::class, 'create'])->name('cvs.create');
            Route::post('', [CVController::class, 'store'])->name('cvs.store');
        });
        //Author Panel
        Route::middleware('author')->prefix('/author_panel')->group(function () {
            Route::get('',[AuthorPanelController::class, 'index'])->name('author.panel');
            Route::get('/news',[AuthorPanelController::class, 'news'])->name('author.posts.index');
        });

        Route::middleware('admin')->prefix('/admin_panel')->group(function () {
            Route::get('/dashboard', DashboardController::class)->name('admin.dashboard');
            Route::prefix('/news')->group(function () {
                Route::get('', [AdminPostController::class, 'index'])->name('admin.posts.index');
                Route::get('/create/', [AdminPostController::class, 'create'])->name('admin.posts.create');
                Route::post('', [AdminPostController::class, 'store'])->name('admin.posts.store');
                Route::get('/{post}', [AdminPostController::class, 'show'])->name('admin.posts.show');
                Route::get('/{post}/edit', [AdminPostController::class, 'edit'])->name('admin.posts.edit');
                Route::patch('/{post}', [AdminPostController::class, 'update'])->name('admin.posts.update');
            });
            Route::prefix('/comments')->group(function () {
                Route::get('/', [AdminCommentController::class, 'index'])->name('admin.comments.index');
                Route::get('/{comment}/edit', [AdminCommentController::class, 'edit'])->name('admin.comments.edit');
                Route::patch('/{comment}', [AdminCommentController::class, 'update'])->name('admin.comments.update');
            });
            Route::prefix('/users')->group(function () {
                Route::get('', [AdminUserController::class, 'index'])->name('admin.users.index');
                Route::get('/create/', [AdminUserController::class, 'create'])->name('admin.users.create');
                Route::post('', [AdminUserController::class, 'store'])->name('admin.users.store');
                Route::get('/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');
                Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
                Route::post('/{user}/ban', [AdminUserController::class, 'ban'])->name('admin.users.ban');
                Route::post('/{user}/un_ban', [AdminUserController::class, 'unban'])->name('admin.users.unban');
                Route::get('/{user}/permission/add', [AdminUserController::class, 'add_permission'])->name('admin.users.permissions.add');
                Route::post('/{user}/permission', [AdminUserController::class, 'store_permission'])->name('admin.users.permissions.store');
            });
            Route::prefix('/cvs')->group(function () {
                Route::get('', [AdminCVController::class, 'index'])->name('admin.cvs.index');
                Route::get('/{cv}', [AdminCVController::class, 'show'])->name('admin.cvs.show');
                Route::post('/{cv}/accept', [AdminCVController::class, 'accept'])->name('admin.cvs.accept');
                Route::post('/{cv}/refuse', [AdminCVController::class, 'refuse'])->name('admin.cvs.refuse');
            });
            Route::prefix('/roles')->group(function () {
                Route::get('', [AdminRoleController::class, 'index'])->name('admin.roles.index');
                Route::get('/create', [AdminRoleController::class, 'create'])->name('admin.roles.create');
                Route::post('', [AdminRoleController::class, 'store'])->name('admin.roles.store');
                Route::get('/{role}/edit', [AdminRoleController::class, 'edit'])->name('admin.roles.edit');
                Route::get('/{role}/permission/add', [AdminRoleController::class, 'add_permission'])->name('admin.roles.permissions.add');
                Route::post('/{role}/permission', [AdminRoleController::class, 'store_permission'])->name('admin.roles.permissions.store');
            });
            Route::prefix('/permissions')->group(function () {
                Route::get('', [AdminPermissionController::class, 'index'])->name('admin.permissions.index');
                Route::get('/create', [AdminPermissionController::class, 'create'])->name('admin.permissions.create');
                Route::post('', [AdminPermissionController::class, 'store'])->name('admin.permissions.store');
                Route::get('/{permission}/edit', [AdminPermissionController::class, 'edit'])->name('admin.permissions.edit');
            });
        });
    });
        Route::get('/', [PostController::class, 'index'])->name('posts.index');
        Route::get('/news', [PostController::class, 'index'])->name('posts.index');
        Route::get('/news/{post}', [PostController::class, 'show'])->name('posts.show');
});




