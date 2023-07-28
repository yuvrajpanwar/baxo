<aside class="sidebar">

    <div class="sidebar-start">

        <div class="sidebar-head">
            <a href="/" class="logo-wrapper" title="Home">
                            <img class="logo-dark" src="../assets/img/logo-white.webp" alt="logo" width="90%">
            </a>
            <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
                <span class="sr-only">Toggle menu</span>
                <span class="icon menu-toggle" aria-hidden="true"></span>
            </button>
        </div>

        <div class="sidebar-body">
            <ul class="sidebar-body-menu">
                <li>
                    <a class="active" href="./dashboard.php"><span class="icon home" aria-hidden="true"></span>Dashboard</a>
                </li>
                <li>
                    <a class="show-cat-btn" href="##">
                        <span class="icon document" aria-hidden="true"></span>Posts (<?=$total_post_all?>)
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Open list</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a href="./post_list.php">All Posts</a>
                        </li>
                        <li>
                            <a href="./add_post.php">Add new post</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="show-cat-btn" href="##">
                        <span class="icon folder" aria-hidden="true"></span>Categories (<?=$total_category_all?>)
                       <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Open list</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a href="./category_list.php">All categories</a>
                        </li>
                        <li>
                            <a href="./add_category.php">Add category</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="show-cat-btn" href="./tag_list.php">
                    <span class="icon edit" aria-hidden="true"></span>Tags (<?=$total_tags?>)
                       <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Open list</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a href="./tag_list.php">All Tags</a>
                        </li>
                        <li>
                            <a href="./add_tag.php">Add Tag</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="" href="./subscriber.php">
                        <span class="icon user-3" aria-hidden="true"></span>Subscribers                       
                    </a>                   
                </li>
                <!-- <li>
                    <a href="##"><span class="icon setting" aria-hidden="true"></span>Settings</a>
                </li> -->
            </ul>
        </div>

    </div>

    <!-- <div class="sidebar-footer">
        <a href="##" class="sidebar-user">
            <span class="sidebar-user-img">
                <picture><source srcset="./img/avatar/avatar-illustrated-01.webp" type="image/webp"><img src="./img/avatar/avatar-illustrated-01.png" alt="User name"></picture>
            </span>
            <div class="sidebar-user-info">
                <span class="sidebar-user__title">Nafisa Sh.</span>
                <span class="sidebar-user__subtitle">Support manager</span>
            </div>
        </a>
    </div> -->

</aside>