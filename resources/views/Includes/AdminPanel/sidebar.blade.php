<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
        data-accordion="false">
        <li class="nav-header">Панель</li>
        <li class="nav-item">
            <a href="{{route('admin.dashboard')}}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-newspaper"></i>
                <p>
                    Новости
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">

                    <a href="{{route('admin.posts.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-align-justify"></i>
                        <p>
                            Все новости
                            <span class="badge badge-info right"></span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.posts.create')}}" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-plus"></i>
                        <p>Добавить новость</p>

                    </a>
                </li>


                <li hidden class="nav-item">
                    <a href="{{route('admin.posts.edit', isset($post)?$post->id:false)}}" class="nav-link">
                        <i class="nav-icon fas fa-pen"></i>
                        <p>Изменить новость</p>
                    </a>
                </li>
                <li hidden class="nav-item">
                    <a href="{{route('admin.posts.show', isset($post)?$post->id:false)}}" class="nav-link">
                        <i class="nav-icon fas fa-eye"></i>
                        <p>Просмотр новости</p>
                    </a>
                </li>
            </ul>

        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-user"></i>
                <p>
                    Пользователи
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('admin.users.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-align-justify"></i>
                        <p>Список пользователей</p>
                    </a>
                </li>
                <li hidden class="nav-item">
                    <a href="{{route('admin.users.edit', isset($user)?$user->id:false)}}" class="nav-link">
                        <i class="nav-icon fas fa-pen"></i>
                        <p>Изменить пользователя</p>
                    </a>
                </li>
                <li hidden class="nav-item">
                    <a href="{{route('admin.users.show', isset($user)?$user->id:false)}}" class="nav-link">
                        <i class="nav-icon fas fa-eye"></i>
                        <p>Просмотр пользователя</p>
                    </a>
                </li>
                <li hidden class="nav-item">
                    <a href="{{route('admin.users.permissions.add', isset($user)?$user->id:false)}}" class="nav-link">
                        <i class="nav-icon fas fa-key"></i>
                        <p>Добавление разрешения</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-list-check"></i>
                <p>
                    Управление ролями
                    <i class="right fas fa-angle-left"></i>
                </p>

            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('admin.roles.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-person"></i>
                        <p>Список ролей</p>
                        <span class="badge badge-info right"></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.permissions.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-key"></i>
                        <p>Список разрешений</p>
                    </a>
                </li>
            </ul>

        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-comment"></i>
                <p>
                    Комментарии
                    <i class="right fas fa-angle-left"></i>
                </p>

            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('admin.comments.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-align-justify"></i>
                        <p>Список комментариев</p>
                        <span class="badge badge-info right"></span>
                    </a>
                </li>
                <li hidden class="nav-item">
                    <a href="{{route('admin.comments.edit', isset($comment)?$comment->id:false)}}" class="nav-link">
                        <i class="nav-icon fas fa-pen"></i>
                        <p>Изменить комментарий</p>
                    </a>
                </li>
            </ul>

        </li>
        <li class="nav-item">
            <a href="{{route('admin.cvs.index')}}" class="nav-link">
                <i class="nav-icon fas fa-solid fa-file"></i>
                <p>Резюме</p>
            </a>
        </li>

    </ul>
</nav>
