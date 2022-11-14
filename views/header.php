<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <title>Share confessions and secrets - SpillTheTea</title>
    <link rel="icon" href="/favicontea.png">

    <meta property="og:image" content="https://spillthetea.social/favicontea.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1024">
    <meta property="og:image:height" content="1024">

    <link rel="stylesheet" href="/views/styles.css">

    <script src="https://kit.fontawesome.com/ee5e6b4c38.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <!-- jQuery UI -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

  </head>

  <body>
      <div class="preloader"><code><strong>Loading...</strong></code></div>

      <div id="fancy-alert" class="alert alert-success alert-dismissible fade show" role="alert">
        <div id="fancy-alert-text"></div>
        <button type="button" id="fancy-alert-close" class="btn-close" aria-label="Close"></button>
      </div>

      <div class="container-fluid" id="header-post-count">There are <?php 

      $query = "SELECT * FROM `tea`";
      $result = mysqli_query($link, $query);

      $numOfPosts = mysqli_num_rows($result);

      echo $numOfPosts + 1;


    ?> posts!</div>

    <?php 

      if (!isset($_COOKIE["newVisitor"])) {
        ?> <div class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
    <?php  } ?>



      <nav class="navbar navbar-expand-xxl fixed-bottom navbar-dark navbar-custom">
  <div class="container-fluid">
    <a class="navbar-brand" title="Credit to © captainvector, Free Images for Tea Icon" href="/"><img src="/spillthetea5.png" height="50px"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span style="color:#FFA500;"><i class="fa-solid fa-chevron-up" id="toggleMenuIcon"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item" style="order:2;">
          <a class="btn nav-link support-dev-link" href="https://www.buymeacoffee.com/coderpr0grammer">Support the Developer</a>
        </li>
        <li class="nav-item" style="order:3;">
          <a class="nav-link active mobile-show" href="/explore/"><i class="fa-regular fa-compass" style="font-size:120%; position:relative; top: 2px;"></i> Explore</a>
        </li>

        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Explore Tea
          </a>
          <ul class="dropdown-menu" style="padding: 5px; min-width: 300px;">
            <li>
              <a class="dropdown-item" href="/explore">All Tea</a>
            </li>
            <hr class="" style="margin: 5px 10px 10px 10px;">
            
          </ul>
        </li> -->
        <!-- <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/confessions">See Confessions</a>
        </li> -->

        <li class="nav-item" style="order:3;">
          <a class="nav-link active mobile-show" href="#" data-bs-toggle="modal"data-bs-target="#confess"><svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="12" r="9"></circle><line x1="9" y1="12" x2="15" y2="12"></line><line x1="12" y1="9" x2="12" y2="15"></line></svg> <span class="nav-text">Spill Tea</span></a>
        </li>

        <li class="nav-item" id="searchNavItem" style="order:3;">
          <div class="input-group mb-3">
            <form class="d-flex" role="search" id="searchForm">
              <input style="border-color: transparent; border-radius:10rem; background-color: rgba(0,0,0,0.5); color: rgba(255, 255, 255, 0.8)" class="form-control me-2" type="text" placeholder="Search your school" aria-label="Search" class="autocomplete" id="navbarSearch" required>
              <span class="input-group-append" id="basic-addon2" style="margin-left:-50px;">
                <button class="btn btn-outline-success" type="submit" style="color: rgba(255, 255, 255, 0.8); border-color: transparent; border-left:none; border-radius: 0rem 10rem 10rem 0rem; background-color:rgba(0,0,0,0); "><i class="fa-solid fa-magnifying-glass"></i></button>
              </span>
              
            </form>
          </div>
              
        </li>

      </ul>

        <?php //print_r($_COOKIE); 
        if (!isset($_COOKIE['id'])) {?>
        <button class="btn btn-outline-custom" id="loginSignupButton" style="margin-bottom:10px;" data-bs-toggle="modal"data-bs-target="#loginSignupModal"><br><small style="font-size:80%">No email required</small></button>

        <?php } else {?>
          <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item dropdown" id="userProfileIcon">
          <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-user" id="userIcon"></i>&nbsp;


             <?php 

            $query = "SELECT `username` FROM `users` WHERE `id`='" . mysqli_real_escape_string($link, $_COOKIE["id"]) . "'";
            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_assoc($result);

            echo '<span style="font-family: Freude, Roboto; text-transform: capitalize; font-size: 1.5rem" id="usernameSpan" data-user-id=' . $_COOKIE["id"] . '>' . $row["username"] . '</span>';

          ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" style="padding: 5px; min-width: 100px;">
            <li>
              <a class="dropdown-item" href="#" data-bs-toggle="modal"data-bs-target="#registerGroupModal">Create a community</a>
              <a class="dropdown-item text-danger" href="#" id="logoutButton">Log out</a>
            </li>
          </ul>
        </li>
      </ul>
        <?php }?>
    </div>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4802401755527530"
     crossorigin="anonymous"></script>
  </div>

</nav>


<!-- Register Group Modal -->
<div class="modal fade" id="registerGroupModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="color:#000000;">Create a Tea Group</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" id="registrationError"></div>
          <div class="alert alert-success" id="registrationSuccess">Creation Successfull! Your community '<span id="groupDetails"></span>' can now receive Tea.<br><br><span id="sharing-link"></span></div>
          <form id="registerGroupForm">
            <div class="form-group">
              <label for="usernameInput" style="color:#000000;">Group Name</label>
              <input type="text" class="form-control" placeholder="e.g. Maple H.S Nicest Confessions" id="groupName"maxlength="20" required>
              <small class="form-text text-muted">This will be the name that will show up above Tea posted in this group.</small>
            </div>
            <br>
            <div class="form-group">
              <label for="groupDescription" style="color:#000000;">Description</label>
              <input type="text" class="form-control" placeholder="This group is for nice confessions at Maple High!" id="groupDescription" required maxlength="100">
              <small class="form-text text-muted">A brief description of what kind of content appears in this group (max 100 char.)</small>
            </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary" id="registerGroupButton">Create</button>
            </div>
          </form>

    </div>
  </div>
</div>

<!-- Confess Modal -->
<div class="modal fade" id="confess" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confessModalTitle" style="color:#000000;">Share Tea Anonymously.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" id="submitTeaError"></div>
          <div class="alert alert-success" id="submitTeaSuccess">Your Tea was successfully posted anonymously.</div>
          <form id="submitTeaForm">
              <h5 style="color:#000000">Post to:</h5>
              <small class="form-text text-muted" style="font-size:70%;">Leave this field blank if you want to post it to "Tea of the World".</small>
              <div class="dropdown">
                <input style="border: 0.5px solid rgba(0, 0, 0, 0.2); border-radius:10rem; background-color: rgba(255, 255, 255, 1); color: rgba(0, 0, 0, 1)" class="form-control me-2" type="text" placeholder="Search your school" aria-label="Search" class="autocomplete" id="confessModalSearch" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">

                <ul class="dropdown-menu" style="padding: 5px; min-width: 300px;" id="dropdownSearch">

                <strong style="color:rgba(0,0,0,0.8);">Your Communities:</strong>
                <hr style="margin-top:5px; margin-bottom:5px;">
                <div id="dropdownYourCommunities"></div>
                  <?php

                    // if(isset($_COOKIE['id'])) {
                    //   //user is logged in

                    //   $query = "SELECT * FROM `groupfollowers` WHERE `userid`='" . mysqli_real_escape_string($link, $_COOKIE['id']) . "'";
                    //   $result = mysqli_query($link, $query);

                    //   if (mysqli_num_rows($result) > 0) {

                    //     while ($row = mysqli_fetch_assoc($result)) {
                    //       $groupid = $row["groupid"];
                    //       $query2 = "SELECT * from `groups` WHERE `id`='". mysqli_real_escape_string($link, $groupid) . "' ORDER BY name ASC";
                    //       $result2 = mysqli_query($link, $query2);
                    //       if ($groupRow = mysqli_fetch_assoc($result2)) {
                    //         $groupName = $groupRow["name"];
                    //         echo "<li class='dropdown-item teaYourGroups'>" . $groupName . "</li>";                          
                    //       }
                    //      }
                    //    } else {
                    //     echo "You haven't joined any communities.";
                    //    }

                    // } else {
                    //   //user is not logged in
                    //   echo "Login to join communities.";
                    // }

                  ?>
                  <!-- <li>
              <a class="dropdown-item" href="/explore">All Confessions</a>
            </li> -->
                </ul>
              </div>
              <span class="input-group-append"  style="margin-left:-50px;">
                <i class="fa-solid fa-magnifying-glass" style="color:#000000;"></i>
              </span>
              

            <div class="form-group">
              <small class="form-text text-muted">Keep it nice, please.</small>
              <textarea class="form-control" placeholder="omg i have a crush on this website 🤭" id="teaTextarea" maxlength="280" required></textarea>
              
            </div>
      </div>
      <div class="modal-footer">
        <img src="/loading.svg" width="50" height="50" class="loading-icon">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" id="submitTeaButton" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Login Signup Modal -->
<div class="modal fade" id="loginSignupModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginTitle" style="color:#000000;">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger" id="loginError"></div>
          <div class="alert alert-success" id="loginSuccess">Login Successfull! Redirecting you to the home page in <span id="countdown"></span>2 seconds...</div>
          <div class="alert alert-success" id="signupSuccess">Signup Successfull! Logging you in...</div>
          <form id="loginSignupForm">
            <div class="form-group">
              <label for="usernameInput" style="color:#000000;">Username</label>
              <input type="text" required class="form-control" id="usernameInput" placeholder="e.g. coderpr0grammer">
              <i class="fa-solid fa-circle-info" style="color:#183153;"></i> <small class="form-text text-muted">This will be your alias used for commenting on posts. <br>Your username is not shared with anyone when sharing tea.</small>
            </div>
            <br>
            <div class="form-group">
              <label for="passwordInput" style="color:#000000;">Password</label>
              <input type="password" required class="form-control" id="passwordInput" placeholder="Make sure its secure">
            </div>
            <p></p>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="stayLoggedInInput">
              <label class="form-check-label" for="stayLoggedInInput" style="color:#000000;">Keep me logged in</label>
            </div>
            <input type="hidden" id="isLoggingIn" value="1">
          
          
      </div>
          <div class="modal-footer">
            <a href="#" class="text-primary" style="text-decoration: none;" id="loginSignupToggle">Sign Up</a>
            <button type="submit" class="btn btn-primary" id="loginButton">Login</button>
          </div>
        </form>
    </div>
  </div>
</div>