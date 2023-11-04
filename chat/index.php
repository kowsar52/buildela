<?php

require_once '../serverside/crud.php';
require_once '../serverside/functions.php';
include_once '../serverside/session.php';

$db = new Database();
$db->connect();

$func = new Functions();
$func->setlastSeen($_SESSION['user_id']);
$chatUsers = $func->getMyChatUsers();
$userInfo = $func->UserInfo($_SESSION['user_id']);

$messages = array();
if (isset($_GET['touserid'])) {
    $touserid = $_GET['touserid'];
    $my_id = $_SESSION['user_id'];

    $chatUsers = $func->getMyChatUsers();

    $messages = $func->getAllMyChates($_GET['touserid'], 352);
    $to_user = $func->UserInfo($_GET['touserid']);
    $to_last_seen = $func->last_seen($_GET['touserid']);
} else {
    $chatUsers = $func->getMyChatUsers();
}

include_once '../includes/header.php';
?>
 <link href="chat.css?v=0.010" rel="stylesheet" type="text/css">
 <script src="chat.js?v=0.010"></script>
<!-- main section start  -->
<section>
    <div class="chat-wrapper">
    <div class="main-layout">
 
 <!-- Sidebar Start -->
 <aside class="sidebar">
     <!-- Tab Content Start -->
     <div class="tab-content">
         <!-- Chat Tab Content Start -->
         <div class="tab-pane active" id="chats-content">
             <div class="d-flex flex-column h-100">
                 <div class="hide-scrollbar h-100" id="chatContactsList">
                     
                     <!-- Chat Header Start -->
                     <div class="sidebar-header sticky-top p-2">
    <div class="d-flex justify-content-between align-items-center">
        <!-- Chat Tab Pane Title Start -->
        <h5 class="font-weight-semibold mb-0">Chats</h5>
        <!-- Chat Tab Pane Title End -->

        
    </div>

    <!-- Sidebar Header Start -->
    <div class="sidebar-sub-header">
        <!-- Sidebar Header Dropdown Start -->
        <div class="dropdown mr-2">
            <!-- Dropdown Button Start -->
            <button class="btn btn-outline-default dropdown-toggle" type="button" data-chat-filter-list="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                All Chats
            </button>
            <!-- Dropdown Button End -->

            <!-- Dropdown Menu Start -->
            <div class="dropdown-menu">
                <a class="dropdown-item" data-chat-filter="" data-select="all-chats" href="#">All Chats</a>
                <a class="dropdown-item" data-chat-filter="" data-select="friends" href="#">Friends</a>
                <a class="dropdown-item" data-chat-filter="" data-select="groups" href="#">Groups</a>
                <a class="dropdown-item" data-chat-filter="" data-select="unread" href="#">Unread</a>
                <a class="dropdown-item" data-chat-filter="" data-select="archived" href="#">Archived</a>
            </div>
            <!-- Dropdown Menu End -->
        </div>
        <!-- Sidebar Header Dropdown End -->

        <!-- Sidebar Search Start -->
        <form class="form-inline">
            <div class="input-group">
                <input type="text" class="form-control search border-right-0 transparent-bg pr-0" placeholder="Search users" />
                <div class="input-group-append">
                    <div class="input-group-text transparent-bg border-left-0" role="button">
                        <!-- Default :: Inline SVG -->
                        <svg class="text-muted hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>

                        <!-- Alternate :: External File link -->
                        <!-- <img class="injectable hw-20" src="./../../assets/media/heroicons/outline/search.svg" alt=""> -->
                    </div>
                </div>
            </div>
        </form>
        <!-- Sidebar Search End -->
    </div>
    <!-- Sidebar Header End -->
</div>

                     <!-- Chat Header End -->

                     <!-- Chat Contact List Start -->
                     <ul class="contacts-list" id="chatContactTab" data-chat-list="">
                        <?php foreach($chatUsers as $user):?>
                         <!-- Chat Item Start -->
                         <li class="contacts-item friends">
                             <a class="contacts-link" href="?touserid=<?= $user['receiver_id']?>">
                                 <div class="avatar avatar-online">
                                     <img src="../admin/images/chat-img.png" alt="">
                                 </div>
                                 <div class="contacts-content">
                                     <div class="contacts-info">
                                         <h6 class="chat-name text-truncate">Catherine Richardson</h6>
                                         <div class="chat-time">Just now</div>
                                     </div>
                                     <div class="contacts-texts">
                                         <p class="text-truncate">I’m sorry, I didn’t catch that. Could you please repeat?</p>
                                     </div>
                                 </div>
                             </a>
                         </li>
                         <!-- Chat Item End -->

                         <!-- Chat Item Start -->
                         <li class="contacts-item unread">
                             <a class="contacts-link" href="?touserid=<?= $user['receiver_id']?>">
                                 <div class="avatar avatar-online">
                                     <img src="../admin/images/chat-img.png" alt="">
                                 </div>
                                 <div class="contacts-content">
                                     <div class="contacts-info">
                                         <h6 class="chat-name">Christina Turner</h6>
                                         <div class="chat-time">
                                             <span>31/05/20</span>
                                         </div>
                                     </div>
                                     <div class="contacts-texts">
                                         <p class="text-truncate">I’m working hard in Maths, Physics and Chemistry. I have planning to appear in I.I.T. after XII.</p>
                                         <div class="badge badge-rounded badge-primary ml-1">10</div>
                                     </div>
                                 </div>
                             </a>
                         </li>
                         <!-- Chat Item End -->
                         <?php  endforeach; ?>
                     </ul>
                     <!-- Chat Contact List End -->
                 </div>
             </div>
         </div>
         <!-- Chats Tab Content End -->

  

       

     </div>
     <!-- Tab Content End -->
 </aside>

 <!-- Sidebar End -->
<?php if($to_user): ?> 
<main class="main main-visible">
    <!-- Chats Page Start -->
    <div class="chats">
        <div class="chat-body">
            <!-- Chat Header Start-->
            <div class="chat-header">
                <!-- Chat Back Button (Visible only in Small Devices) -->
                <button class="btn btn-secondary btn-icon btn-minimal btn-sm text-muted d-xl-none" type="button" data-close="">
                    <!-- Default :: Inline SVG -->
                    <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </button>

                <!-- Chat participant's Name -->
                <div class="media chat-name align-items-center text-truncate">
                    <div class="avatar avatar-online d-none d-sm-inline-block mr-3">
                        <img src="../admin/images/chat-img.png" alt="" />
                    </div>

                    <div class="media-body align-self-center">
                        <h6 class="text-truncate mb-0">MR Luke </h6>
                        <small class="text-muted">Online</small>
                    </div>
                </div>

                <!-- Chat Options -->
                <ul class="nav flex-nowrap">
                    <!-- <li class="nav-item list-inline-item d-none d-sm-block mr-1">
                        <a class="nav-link text-muted px-1" href="#" title="Leads">
                            <img src="./img/lists.png" alt="" class="injectable hw-22">
                        </a>
                    </li> -->
                    <li class="nav-item list-inline-item  mr-0">
                        <div class="dropdown">
                            <a class="nav-link text-muted px-1" href="#" role="button" title="Details" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                </svg>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item align-items-center d-flex" href="#" data-chat-info-toggle="">
                                    <!-- Default :: Inline SVG -->
                                    <svg class="hw-20 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>

                                    <!-- Alternate :: External File link -->
                                    <span>View Leads</span>
                                </a>
                                <a class="dropdown-item align-items-center d-flex" href="#">
                                    <!-- Default :: Inline SVG -->
                                    <svg class="hw-20 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                        ></path>
                                    </svg>
                                    <span>Delete</span>
                                </a>
                                <a class="dropdown-item align-items-center d-flex text-danger" href="#">
                                    <!-- Default :: Inline SVG -->
                                    <svg class="hw-20 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                    </svg>

                                    <span>Block</span>
                                </a>
                            </div>
                        </div>
                    </li>
                   
                </ul>
            </div>
            <!-- Chat Header End-->

         

            <!-- Chat Content Start-->
            <div class="chat-content p-2" id="messageBody">
                <div class="container">
                    <!-- Message Day Start -->
                    <div class="message-day">
                        <div class="message-divider sticky-top pb-2" data-label="Yesterday">&nbsp;</div>

                        <!-- Received Message Start -->
                        <div class="message">
                            <div class="message-wrapper">
                                <div class="message-content">
                                    <span>I have to give a presentation on global warming on Friday, and I am so nervous.</span>
                                </div>
                            </div>
                            <div class="message-options">
                                <div class="avatar avatar-sm"><img alt="" src="../admin/images/chat-img.png" /></div>
                                <span class="message-date">9:12am</span>
                                
                            </div>
                        </div>
                        <!-- Received Message End -->

                        <!-- Self Message Start -->
                        <div class="message self">
                            <div class="message-wrapper">
                                <div class="message-content">
                                    <span>
                                        First of all, you need to understand the subject matter thoroughly. You need to know what is global warming, what causes global warming, and what people should do to abate the effects of global
                                        warming.
                                    </span>
                                </div>
                            </div>
                            <div class="message-options">
                                <div class="avatar avatar-sm"><img alt="" src="../admin/images/chat-img.png" /></div>

                                <span class="message-date">9:12am</span>
                                <span class="message-status">Edited</span>

                               
                            </div>
                        </div>
                        <!-- Self Message End -->

                        <!-- Received Message Start -->
                        <div class="message">
                            <div class="message-wrapper">
                                <div class="message-content">
                                    <span>I have done a lot of research on the subject, and I know I can answer any questions I will receive from the audience.</span>
                                </div>
                            </div>
                            <div class="message-options">
                                <div class="avatar avatar-sm"><img alt="" src="../admin/images/chat-img.png" /></div>
                                <span class="message-date">9:12am</span>
                                
                            </div>
                        </div>
                        <!-- Received Message End -->

                        <!-- Received Message Start -->
                        <div class="message">
                            <div class="message-wrapper">
                                <div class="message-content">
                                    <h6>I have shared some photos, Please have a look.</h6>
                                    <div class="form-row">
                                        <div class="col">
                                            <a class="popup-media" href="../admin/images/chat-img.png">
                                                <img class="img-fluid rounded" src="../admin/images/chat-img.png" alt="" />
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="popup-media" href="./../../assets/media/shared-photos/02.jpg">
                                                <img class="img-fluid rounded" src="./../../assets/media/shared-photos/02.jpg" alt="" />
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="popup-media" href="./../../assets/media/shared-photos/03.jpg">
                                                <img class="img-fluid rounded" src="./../../assets/media/shared-photos/03.jpg" alt="" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="message-options">
                                <div class="avatar avatar-sm"><img alt="" src="./../../assets/media/avatar/6.png" /></div>
                                <span class="message-date">9:12am</span>
                            </div>
                        </div>

                        <!-- Received Message End -->

                        <!-- Received Message Start -->
                        <div class="message">
                            <div class="message-wrapper">
                                <div class="message-content">
                                    <span>I should talk about more precisely the sequence of my presentation?</span>
                                </div>
                            </div>
                            <div class="message-options">
                                <div class="avatar avatar-sm"><img alt="" src="../admin/images/chat-img.png" /></div>
                                <span class="message-date">9:12am</span>
                                
                            </div>
                        </div>
                        <!-- Received Message End -->

                        <!-- Self Message Start -->
                        <div class="message self">
                            <div class="message-wrapper">
                                <div class="message-content"><span>Yes, what you should present first, second and third…</span></div>
                            </div>
                            <div class="message-options">
                                <div class="avatar avatar-sm"><img alt="" src="../admin/images/chat-img.png" /></div>

                                <span class="message-date">9:12am</span>

                               
                            </div>
                        </div>
                        <!-- Self Message End -->

                        <!-- Message Start -->
                        <div class="message">
                            <div class="message-wrapper">
                                <div class="message-content">
                                    <div class="document">
                                        <div class="btn btn-primary btn-icon rounded-circle text-light mr-2">
                                            <!-- Default :: Inline SVG -->
                                            <svg class="hw-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>

                                            <!-- Alternate :: External File link -->
                                            <!-- <img class="injectable hw-24" src="./../../assets/media/heroicons/outline/document.svg" alt=""> -->
                                        </div>

                                        <div class="document-body">
                                            <h6>
                                                <a href="#" class="text-reset" title="global-warming-data-2020.xlxs">global-warming-data-2020.xlxs</a>
                                            </h6>

                                            <ul class="list-inline small mb-0">
                                                <li class="list-inline-item">
                                                    <span class="text-muted">79.2 KB</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <span class="text-muted text-uppercase">xlxs</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="message-options">
                                <div class="avatar avatar-sm"><img alt="" src="../admin/images/chat-img.png" /></div>

                                <span class="message-date">9:12am</span>

                                <div class="dropdown">
                                    <a class="text-muted" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <!-- Default :: Inline SVG -->
                                        <svg class="hw-18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"
                                            ></path>
                                        </svg>

                                        <!-- Alternate :: External File link -->
                                        <!-- <img class="injectable hw-18" src="./../../assets/media/heroicons/outline/dots-horizontal.svg" alt="message options"> -->
                                    </a>

                                    <div class="dropdown-menu">
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <!-- Default :: Inline SVG -->
                                            <svg class="hw-18 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>

                                            <!-- Alternate :: External File link -->
                                            <!-- <img class="injectable hw-18 mr-2" src="./../../assets/media/heroicons/outline/download.svg" alt="download"> -->
                                            <span>Download</span>
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <!-- Default :: Inline SVG -->
                                            <svg class="hw-18 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                            </svg>

                                            <!-- Alternate :: External File link -->
                                            <!-- <img class="injectable hw-18 mr-2" src="./../../assets/media/heroicons/outline/reply.svg" alt="message replay"> -->
                                            <span>Replay</span>
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <!-- Default :: Inline SVG -->
                                            <svg class="hw-18 rotate-y mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                            </svg>

                                            <!-- Alternate :: External File link -->
                                            <!-- <img class="injectable rotate-y hw-18 mr-2" src="./../../assets/media/heroicons/outline/reply.svg" alt="message forward"> -->
                                            <span>Forward</span>
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <!-- Default :: Inline SVG -->
                                            <svg class="hw-18 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"
                                                ></path>
                                            </svg>

                                            <!-- Alternate :: External File link -->
                                            <!-- <img class="injectable hw-18 mr-2" src="./../../assets/media/heroicons/outline/star.svg" alt="message favourite"> -->
                                            <span>Favourite</span>
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center text-danger" href="#">
                                            <!-- Default :: Inline SVG -->
                                            <svg class="hw-18 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                ></path>
                                            </svg>

                                            <!-- Alternate :: External File link -->
                                            <!-- <img class="injectable hw-18 mr-2" src="./../../assets/media/heroicons/outline/trash.svg" alt="message delete"> -->
                                            <span>Delete</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Message End -->

                        <!-- Received Message Start -->
                        <div class="message">
                            <div class="message-wrapper">
                                <div class="message-content">
                                    <span>If that is the case, then I already have an outline. To make it easy for my audience to follow the presentation, I intend to post the outline on the board at all time during my speech.</span>
                                </div>
                            </div>
                            <div class="message-options">
                                <div class="avatar avatar-sm"><img alt="" src="../admin/images/chat-img.png" /></div>
                                <span class="message-date">9:12am</span>
                                
                            </div>
                        </div>
                        <!-- Received Message End -->
                    </div>
                    <!-- Message Day End -->

                    <!-- Message Day Start -->
                    <div class="message-day">
                        <div class="message-divider sticky-top pb-2" data-label="Today">&nbsp;</div>

                        <!-- Self Message Start -->
                        <div class="message self">
                            <div class="message-wrapper">
                                <div class="message-content"><span>Good idea! By the way, do you have any facts to back you up? For example, change of climate, yearly disasters…</span></div>
                            </div>
                            <div class="message-options">
                                <div class="avatar avatar-sm"><img alt="" src="../admin/images/chat-img.png" /></div>

                                <span class="message-date">9:12am</span>
                                <span class="message-status">Edited</span>


                            </div>
                        </div>
                        <!-- Self Message End -->
                        <!-- Received Message Start -->
                        <div class="message">
                            <div class="message-wrapper">
                                <div class="message-content"><span>No, I have not thought about that. I better get some statistics from the Internet. I should not have any problems since the Internet has all kinds of data.</span></div>
                            </div>
                            <div class="message-options">
                                <div class="avatar avatar-sm"><img alt="" src="../admin/images/chat-img.png" /></div>
                                <span class="message-date">9:12am</span>
                                
                            </div>
                        </div>
                        <!-- Received Message End -->

                        <!-- Self Message Start -->
                        <div class="message self">
                            <div class="message-wrapper">
                                <div class="message-content"><span>Pictures will keep your audience from being bored. In order for you to succeed, you need to keep them interested and involved.</span></div>
                            </div>
                            <div class="message-options">
                                <div class="avatar avatar-sm"><img alt="" src="../admin/images/chat-img.png" /></div>

                                <span class="message-date">9:12am</span>

                               
                            </div>
                        </div>
                        <!-- Self Message End -->

                        <!-- Received Message Start -->
                        <div class="message">
                            <div class="message-wrapper">
                                <div class="message-content"><span>You are absolutely right. I will take time to practice and to learn to relax and express myself really well. Wish me luck, Catherine!</span></div>
                            </div>
                            <div class="message-options">
                                <div class="avatar avatar-sm"><img alt="" src="../admin/images/chat-img.png" /></div>
                                <span class="message-date">9:12am</span>
                                
                            </div>
                        </div>
                        <!-- Received Message End -->

                        <!-- Self Message Start -->
                        <div class="message self">
                            <div class="message-wrapper">
                                <div class="message-content"><span>I know you. You can do it. Good luck, Jennifer!</span></div>
                            </div>
                            <div class="message-options">
                                <div class="avatar avatar-sm"><img alt="" src="../admin/images/chat-img.png" /></div>

                                <span class="message-date">Just now</span>

                               
                            </div>
                        </div>
                        <!-- Self Message End -->
                    </div>
                    <!-- Message Day End -->
                </div>

                <!-- Scroll to finish -->
                <div class="chat-finished" id="chat-finished"></div>
            </div>
            <!-- Chat Content End-->

            <!-- Chat Footer Start-->
            <div class="chat-footer">
                <div class="attachment">
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-icon btn-minimal btn-sm" type="button" >
                                <svg class="hw-22 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    ></path>
                                </svg>
                        </button>
                    </div>
                </div>

                <textarea class="form-control emojionearea-form-control" id="messageInput" rows="1" placeholder="Type your message here..." ></textarea>
                
                <div class="btn btn-primary btn-icon send-icon rounded-circle text-light mb-1" role="button" type="submit" id="sendMessageBtn">
                    <svg class="hw-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </div>
            </div>
            <!-- Chat Footer End-->
        </div>

        <!-- Chat Info Start -->
        <div class="chat-info">
            <div class="d-flex h-100 flex-column">
                <!-- Chat Info Header Start -->
                <div class="chat-info-header px-2">
                    <div class="container-fluid">
                        <ul class="nav justify-content-between align-items-center">
                            <!-- Sidebar Title Start -->
                            <li class="text-center">
                                <h5 class="text-truncate mb-0">Profile Details</h5>
                            </li>
                            <!-- Sidebar Title End -->

                            <!-- Close Sidebar Start -->
                            <li class="nav-item list-inline-item">
                                <a class="nav-link text-muted px-0" href="#" data-chat-info-close="">
                                    <!-- Default :: Inline SVG -->
                                    <svg class="hw-22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>

                                    <!-- Alternate :: External File link -->
                                    <!-- <img class="injectable hw-22" src="./../../assets/media/heroicons/outline/x.svg" alt=""> -->
                                </a>
                            </li>
                            <!-- Close Sidebar End -->
                        </ul>
                    </div>
                </div>
                <!-- Chat Info Header End  -->

                <!-- Chat Info Body Start  -->
                <div class="hide-scrollbar flex-fill">
                    <!-- User Profile Start -->
                    <div class="text-center p-3">
                        <!-- User Profile Picture -->
                        <div class="avatar avatar-xl mx-5 mb-3">
                            <img class="avatar-img" src="../admin/images/chat-img.png" alt="" />
                        </div>

                        <!-- User Info -->
                        <h5 class="mb-1">Catherine Richardson</h5>
                        <p class="text-muted d-flex align-items-center justify-content-center">
                            <!-- Default :: Inline SVG -->
                            <svg class="hw-18 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>

                            <!-- Alternate :: External File link -->
                            <!-- <img class="injectable mr-1 hw-18" src="./../../assets/media/heroicons/outline/location-marker.svg" alt=""> -->
                            <span>San Fransisco, CA</span>
                        </p>

                        <!-- User Quick Options -->
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="btn btn-outline-default btn-icon rounded-circle mx-1">
                                <!-- Default :: Inline SVG -->
                                <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>

                                <!-- Alternate :: External File link -->
                                <!-- <img class="injectable hw-20" src="./../../assets/media/heroicons/outline/user-add.svg" alt=""> -->
                            </div>
                            <div class="btn btn-primary btn-icon rounded-circle text-light mx-1">
                                <!-- Default :: Inline SVG -->
                                <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                    ></path>
                                </svg>

                                <!-- Alternate :: External File link -->
                                <!-- <img class="injectable hw-20" src="./../../assets/media/heroicons/outline/heart.svg" alt=""> -->
                            </div>
                            <div class="btn btn-danger btn-icon rounded-circle text-light mx-1">
                                <!-- Default :: Inline SVG -->
                                <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>

                                <!-- Alternate :: External File link -->
                                <!-- <img class="injectable hw-20" src="./../../assets/media/heroicons/outline/ban.svg" alt=""> -->
                            </div>
                        </div>
                    </div>
                    <!-- User Profile End -->

                    <!-- User Information Start -->
                    <div class="chat-info-group">
                        <a class="chat-info-group-header" data-toggle="collapse" href="#profile-info" role="button" aria-expanded="true" aria-controls="profile-info">
                            <h6 class="mb-0">User Information</h6>

                            <!-- Default :: Inline SVG -->
                            <svg class="hw-20 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>

                            <!-- Alternate :: External File link -->
                            <!-- <img class="injectable text-muted hw-20" src="./../../assets/media/heroicons/outline/information-circle.svg" alt=""> -->
                        </a>

                        <div class="chat-info-group-body collapse show" id="profile-info">
                            <div class="chat-info-group-content list-item-has-padding">
                                <!-- List Group Start -->
                                <ul class="list-group list-group-flush">
                                    <!-- List Group Item Start -->
                                    <li class="list-group-item border-0">
                                        <p class="small text-muted mb-0">Phone</p>
                                        <p class="mb-0">+01-222-364522</p>
                                    </li>
                                    <!-- List Group Item End -->

                                    <!-- List Group Item Start -->
                                    <li class="list-group-item border-0">
                                        <p class="small text-muted mb-0">Email</p>
                                        <p class="mb-0">catherine.richardson@gmail.com</p>
                                    </li>
                                    <!-- List Group Item End -->

                                    <!-- List Group Item Start -->
                                    <li class="list-group-item border-0">
                                        <p class="small text-muted mb-0">Address</p>
                                        <p class="mb-0">1134 Ridder Park Road, San Fransisco, CA 94851</p>
                                    </li>
                                    <!-- List Group Item End -->
                                </ul>
                                <!-- List Group End -->
                            </div>
                        </div>
                    </div>
                    <!-- User Information End -->

                    <!-- Shared Media Start -->
                    <div class="chat-info-group">
                        <a class="chat-info-group-header" data-toggle="collapse" href="#shared-media" role="button" aria-expanded="true" aria-controls="shared-media">
                            <h6 class="mb-0">Last Media</h6>

                            <!-- Default :: Inline SVG -->
                            <svg class="hw-20 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                ></path>
                            </svg>

                            <!-- Alternate :: External File link -->
                            <!-- <img class="injectable text-muted hw-20" src="./../../assets/media/heroicons/outline/photograph.svg" alt=""> -->
                        </a>

                        <div class="chat-info-group-body collapse show" id="shared-media">
                            <div class="chat-info-group-content">
                                <!-- Shared Media -->
                                <div class="form-row">
                                    <div class="col-4 col-md-2 col-xl-4">
                                        <a href="#">
                                            <img src="./../../assets/media/shared-photos/01.jpg" class="img-fluid rounded border" alt="" />
                                        </a>
                                    </div>
                                    <div class="col-4 col-md-2 col-xl-4">
                                        <a href="#">
                                            <img src="./../../assets/media/shared-photos/02.jpg" class="img-fluid rounded border" alt="" />
                                        </a>
                                    </div>
                                    <div class="col-4 col-md-2 col-xl-4">
                                        <a href="#">
                                            <img src="./../../assets/media/shared-photos/03.jpg" class="img-fluid rounded border" alt="" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Shared Media End -->

                    <!-- Shared Files Start -->
                    <div class="chat-info-group">
                        <a class="chat-info-group-header" data-toggle="collapse" href="#shared-files" role="button" aria-expanded="true" aria-controls="shared-files">
                            <h6 class="mb-0">Documents</h6>

                            <!-- Default :: Inline SVG -->
                            <svg class="hw-20 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>

                            <!-- Alternate :: External File link -->
                            <!-- <img class="injectable text-muted hw-20" src="./../../assets/media/heroicons/outline/document.svg" alt=""> -->
                        </a>

                        <div class="chat-info-group-body collapse show" id="shared-files">
                            <div class="chat-info-group-content list-item-has-padding">
                                <!-- List Group Start -->
                                <ul class="list-group list-group-flush">
                                    <!-- List Group Item Start -->
                                    <li class="list-group-item">
                                        <div class="document">
                                            <div class="btn btn-primary btn-icon rounded-circle text-light mr-2">
                                                <!-- Default :: Inline SVG -->
                                                <svg class="hw-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                </svg>

                                                <!-- Alternate :: External File link -->
                                                <!-- <img class="injectable hw-24" src="./../../assets/media/heroicons/outline/document.svg" alt=""> -->
                                            </div>

                                            <div class="document-body">
                                                <h6 class="text-truncate">
                                                    <a href="#" class="text-reset" title="effects-of-global-warming.docs">Effects-of-global-warming.docs</a>
                                                </h6>

                                                <ul class="list-inline small mb-0">
                                                    <li class="list-inline-item">
                                                        <span class="text-muted">79.2 KB</span>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <span class="text-muted text-uppercase">docs</span>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="document-options ml-1">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary btn-icon btn-minimal btn-sm text-muted" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <!-- Default :: Inline SVG -->
                                                        <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"
                                                            ></path>
                                                        </svg>

                                                        <!-- Alternate :: External File link -->
                                                        <!-- <img class="injectable hw-20" src="./../../assets/media/heroicons/outline/dots-vertical.svg" alt=""> -->
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Download</a>
                                                        <a class="dropdown-item" href="#">Share</a>
                                                        <a class="dropdown-item" href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- List Group Item End -->

                                    <!-- List Group Item Start -->
                                    <li class="list-group-item">
                                        <div class="document">
                                            <div class="btn btn-primary btn-icon rounded-circle text-light mr-2">
                                                <!-- Default :: Inline SVG -->
                                                <svg class="hw-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                </svg>

                                                <!-- Alternate :: External File link -->
                                                <!-- <img class="injectable hw-24" src="./../../assets/media/icons/excel-file.svg" alt=""> -->
                                            </div>

                                            <div class="document-body">
                                                <h6 class="text-truncate">
                                                    <a href="#" class="text-reset" title="global-warming-data-2020.xlxs">Global-warming-data-2020.xlxs</a>
                                                </h6>

                                                <ul class="list-inline small mb-0">
                                                    <li class="list-inline-item">
                                                        <span class="text-muted">79.2 KB</span>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <span class="text-muted text-uppercase">xlxs</span>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="document-options ml-1">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary btn-icon btn-minimal btn-sm text-muted" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <!-- Default :: Inline SVG -->
                                                        <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"
                                                            ></path>
                                                        </svg>

                                                        <!-- Alternate :: External File link -->
                                                        <!-- <img class="injectable hw-20" src="./../../assets/media/heroicons/outline/dots-vertical.svg" alt=""> -->
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">View</a>
                                                        <a class="dropdown-item" href="#">Share</a>
                                                        <a class="dropdown-item" href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- List Group Item End -->

                                    <!-- List Group Item Start -->
                                    <li class="list-group-item">
                                        <div class="document">
                                            <div class="btn btn-primary btn-icon rounded-circle text-light mr-2">
                                                <!-- Default :: Inline SVG -->
                                                <svg class="hw-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                </svg>

                                                <!-- Alternate :: External File link -->
                                                <!-- <img class="injectable hw-24" src="./../../assets/media/icons/powerpoint-file.svg" alt=""> -->
                                            </div>

                                            <div class="document-body">
                                                <h6 class="text-truncate">
                                                    <a href="#" class="text-reset" title="great-presentation-on global-warming-2020.ppt">Great-presentation-on global-warming-2020.ppt</a>
                                                </h6>

                                                <ul class="list-inline small mb-0">
                                                    <li class="list-inline-item">
                                                        <span class="text-muted">79.2 KB</span>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <span class="text-muted text-uppercase">ppt</span>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="document-options ml-1">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary btn-icon btn-minimal btn-sm text-muted" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <!-- Default :: Inline SVG -->
                                                        <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"
                                                            ></path>
                                                        </svg>

                                                        <!-- Alternate :: External File link -->
                                                        <!-- <img class="injectable hw-20" src="./../../assets/media/heroicons/outline/dots-vertical.svg" alt=""> -->
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Download</a>
                                                        <a class="dropdown-item" href="#">Share</a>
                                                        <a class="dropdown-item" href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- List Group Item End -->
                                </ul>
                                <!-- List Group End -->
                            </div>
                        </div>
                    </div>
                    <!-- Shared Files End -->
                </div>
                <!-- Chat Info Body Start  -->
            </div>
        </div>
        <!-- Chat Info End -->
    </div>
    <!-- Chats Page End -->
</main>
<?php else: ?> 
     <!-- Main Start -->
 <main class="main">
     <!-- Chats Page Start -->
     <div class="chats">
         <div class="d-flex flex-column justify-content-center text-center h-100 w-100">
             <div class="container">
                 <div >
                     <img class="align-center mb-4 text-center" src="../admin/images/chat-img.png" height="200px">
                 </div>

                 <h4>Pick up where you left off</h4>
                 <p class="text-muted">Select a conversation and chat away.</p>

                 <!-- <button class="btn btn-outline-primary no-box-shadow" type="button" data-toggle="modal" data-target="#startConversation">
                     Start a conversation
                 </button> -->
             </div>
         </div>
     </div>
     <!-- Chats Page End -->

 </main>
 <!-- Main End -->
<?php endif; ?> 




 <div class="backdrop"></div>



</div>
    </div>
</section>
<!-- main section end -->

<script>
    $(document).ready(function(){
        var conn = new WebSocket('ws://localhost:8080');
        conn.onopen = function(e) {
            console.log("Connection established !");
        };

        conn.onmessage = function(e) {
            console.log(e.data);
            $('#chat-finished').append('<div class="message"><div class="message-wrapper"><div class="message-content"><span>'+e.data+'</span></div></div><div class="message-options"><div class="avatar avatar-sm"><img alt="" src="../admin/images/chat-img.png" /></div><span class="message-date">9:12am</span></div></div>');
        };
        //sendMessageBtn
        $('#sendMessageBtn').on("click",function(){
            var message = $('#messageInput').val();
            conn.send(message);
        })
    })
</script>
<?php include_once '../includes/footer-no-cta.php' ?>
