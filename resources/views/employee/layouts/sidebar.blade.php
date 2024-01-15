<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ route('home.index') }}">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li>

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('projectlist.index') }}">
                <i class="bi bi-person"></i>
                <span>Project List</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('tasklist') }}">
                <i class="bi bi-person"></i>
                <span>Task List</span>
            </a>
        </li>

    </ul>

</aside>
