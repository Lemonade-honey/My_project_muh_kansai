<?php
    session_start();
?>


<header>
    <nav class="sidebar">
        <div class="logo">
            <h1>KANSAI STAFF PORTAL</h1>
            <div class="menu">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
        <ul>
            <li><a href="/admin/src/dashboard.php"><div class="fa-solid fa-grip"></div> Dashboard</a></li>
            <?php if($_SESSION["staff_level"] == 5){?>
            <li>
                <a href="#" class="drop"><div class="fa-solid fa-user-group"></div>member<i class="fas fa-caret-down"></i></a>
                <ul>
                    <li><a href="/admin/src/member/list_member.php">member list</a></li>
                    <li><a href="/admin/src/member/list_member_pending.php">member pendding</a></li>
                    <li><a href="/admin/src/member/list_staff.php">list staff</a></li>
                    <li><a href="/admin/src/member/add_staff.php">add staff</a></li>
                    
                </ul>
            </li>
            <?php }?>
            <li>
                <a href="#" class="drop"><div class="fa-solid fa-newspaper"></div> news<i class="fas fa-caret-down"></i></a>
                <ul>
                    <li><a href="">add news</a></li>
                    <li><a href="">news list</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="drop"><div class="fa-solid fa-table-list"></div> activity<i class="fas fa-caret-down"></i></a>
                <ul>
                    <li><a href="">add activity</a></li>
                    <li><a href="">activity list</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="drop"><div class="fa-solid fa-gear"></div> settings<i class="fas fa-caret-down"></i></a>
                <ul>
                    <li><a href="">image slider config</a></li>
                </ul>
            </li>
        </ul>
        <div class="akun">
            <div class="email"><?php echo $_SESSION["staff_username"]?></div>
            <a href="/account/logout.php"><div class="logout">log</div></a>
        </div>
        
    </nav>
</header>