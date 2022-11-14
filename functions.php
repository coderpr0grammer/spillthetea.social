<?php
    
    session_start();
    setcookie('likes', json_encode(array()), time() + (10 * 365 * 24 * 60 * 60));

    $link = mysqli_connect("localhost", "admin_confession", "Danico2003", "admin_confession");
    $GLOBALS["link"] = $link;
    if (mysqli_connect_errno()) {

        print_r(mysqli_connect_error());
        die ("There was an error connecting to the database");

    }

    function verifiedBadge() {
        echo '<?xml version="1.0" ?><svg class="verified-badge" fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg"><path clip-rule="evenodd" d="M6.26701 3.45496C6.91008 3.40364 7.52057 3.15077 8.01158 2.73234C9.15738 1.75589 10.8426 1.75589 11.9884 2.73234C12.4794 3.15077 13.0899 3.40364 13.733 3.45496C15.2336 3.57471 16.4253 4.76636 16.545 6.26701C16.5964 6.91008 16.8492 7.52057 17.2677 8.01158C18.2441 9.15738 18.2441 10.8426 17.2677 11.9884C16.8492 12.4794 16.5964 13.0899 16.545 13.733C16.4253 15.2336 15.2336 16.4253 13.733 16.545C13.0899 16.5964 12.4794 16.8492 11.9884 17.2677C10.8426 18.2441 9.15738 18.2441 8.01158 17.2677C7.52057 16.8492 6.91008 16.5964 6.26701 16.545C4.76636 16.4253 3.57471 15.2336 3.45496 13.733C3.40364 13.0899 3.15077 12.4794 2.73234 11.9884C1.75589 10.8426 1.75589 9.15738 2.73234 8.01158C3.15077 7.52057 3.40364 6.91008 3.45496 6.26701C3.57471 4.76636 4.76636 3.57471 6.26701 3.45496ZM13.7071 8.70711C14.0976 8.31658 14.0976 7.68342 13.7071 7.29289C13.3166 6.90237 12.6834 6.90237 12.2929 7.29289L9 10.5858L7.70711 9.29289C7.31658 8.90237 6.68342 8.90237 6.29289 9.29289C5.90237 9.68342 5.90237 10.3166 6.29289 10.7071L8.29289 12.7071C8.68342 13.0976 9.31658 13.0976 9.70711 12.7071L13.7071 8.70711Z" fill="orange" fill-rule="evenodd"/></svg>';
    }

    function commentBox($row) {
        echo '<div class="replyingToDiv" data-post-id="' . $row["id"] . '">Replying to @<span class="replyingToText" data-post-id="' . $row["id"] . '"></span><i style="font-size:1rem;" class="fa-solid fa-xmark closeReplyDialog" data-post-id="' . $row["id"] . '"></i><br></div>
        <form autocomplete="off" class="comment-form" role="search" data-post-id="' . $row["id"] . '" style="margin:0px 0px 10px 0px;">
              <input data-post-id="' . $row["id"] . '" style="border-color: transparent; border-radius:10rem; background-color: rgba(0,0,0,0.5); color: rgba(255, 255, 255, 0.8)" class="form-control me-2 comment-box" type="text" placeholder="share your thoughts!" aria-label="Search" required>
              <input type="hidden" class="replyingTo" data-post-id="' . $row["id"] . '" value="">
              <span class="input-group-append" id="basic-addon2" style="margin-left:-75px;">
                <button class="btn text-primary commentButton" data-post-id="' . $row["id"] . '" type="submit" style=" border-color: transparent; border-left:none; border-radius: 0rem 10rem 10rem 0rem; background-color:rgba(0,0,0,0); ">Post</button>
              </span>
              
            </form>';
    }

    function inFeedAdUnit() {
        if (rand(1,4) == 1) {
            echo '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4802401755527530"
         crossorigin="anonymous"></script>
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-format="fluid"
         data-ad-layout-key="-6t+ed+2i-1n-4w"
         data-ad-client="ca-pub-4802401755527530"
         data-ad-slot="6524887699"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>';
        }
    }



    function commentSection($row) {
        $link = $GLOBALS["link"];
        $commentsArray = json_decode($row["comments"]);
        if ($commentsArray != NULL) {
            if (count($commentsArray) > 0) {
                if (count($commentsArray) == 1) {
                    if (count($commentsArray[0]->replies) < 1) {

                        //just show single comment

                        echo "<div class='commentSection' data-post-id=" . $row["id"] . "><span class='comment'>";
                        echo '<span class="comment-user-info" data-comment-username="' . $commentsArray[0]->username . '">';

                        $query = "SELECT * FROM `users` WHERE `username`='" . $commentsArray[0]->username . "' LIMIT 1";
                        $result = mysqli_query($link, $query);
                        $usernameRow = mysqli_fetch_assoc($result);
                        if ($usernameRow["verified"] == 1) {
                            echo '<span class="username-span-on-comment verified-user"><i class="fa-solid fa-user" style="font-size:0.9rem;"></i> @' . $commentsArray[0]->username . " ";
                            echo verifiedBadge();
                            echo ' </span>';
                        } else {
                            echo '<span class="username-span-on-comment"><i class="fa-solid fa-user" style="font-size:0.9rem;"></i> @' . $commentsArray[0]->username .' </span>';
                        }
                        echo "</span>";
                        


                        echo '</span>';
                        echo '&nbsp;&nbsp;<span class="comment-body">' . $commentsArray[0]->comment . '</span>';
                        echo '<br><span class="comment-footer text-muted">' . short_time_since($commentsArray[0]->date) . '&nbsp; <span class="reply-button" data-comment-id="' . $commentsArray[0]->id . '" data-post-id="' . $row["id"] . '" data-username="' . $commentsArray[0]->username . '">Reply</span></div>';
                        // echo "</div>";
                        
                    } else {

                        //show single comment with replies

                        echo "<div class='commentSection' data-post-id=" . $row["id"] . "><span class='comment'>";
                        echo '<span class="comment-user-info" data-comment-username="' . $commentsArray[0]->username . '">';

                        $query = "SELECT * FROM `users` WHERE `username`='" . $commentsArray[0]->username . "' LIMIT 1";
                        $result = mysqli_query($link, $query);
                        $usernameRow = mysqli_fetch_assoc($result);

                        if ($usernameRow["verified"] == 1) {
                            echo '<span class="username-span-on-comment verified-user"><i class="fa-solid fa-user" style="font-size:0.9rem;"></i> @' . $commentsArray[0]->username . " ";
                            echo verifiedBadge();
                            echo ' </span>';
                        } else {
                            
                            echo '<span class="username-span-on-comment"><i class="fa-solid fa-user" style="font-size:0.9rem;"></i> @' . $commentsArray[0]->username .' </span>';

                        }

                        echo "</span>";

                         echo '&nbsp;&nbsp;<span class="comment-body">' . $commentsArray[0]->comment . '</span>';
                        echo '<br><span class="comment-footer text-muted">' . short_time_since($commentsArray[0]->date) . '&nbsp; <span class="reply-button" data-comment-id="' . $commentsArray[0]->id . '" data-post-id="' . $row["id"] . '" data-username="' . $commentsArray[0]->username . '">Reply</span></span>';
                        
                        foreach($commentsArray[0]->replies as $val) {
                            echo '<div class="reply">
                            <span style="opacity:0.5;">&mdash;</span>
                            <span class="comment-user-info" data-comment-username="' . $val->username . '">';

                            $query = "SELECT * FROM `users` WHERE `username`='" . $val->username . "' LIMIT 1";
                            $result = mysqli_query($link, $query);
                            $usernameRow = mysqli_fetch_assoc($result);
                            if ($usernameRow["verified"] == 1) {
                                echo '<span class="username-span-on-comment verified-user"><i class="fa-solid fa-user" style="font-size:0.9rem;"></i> @' . $val->username . " ";
                                echo verifiedBadge();
                                echo ' </span>';
                            } else {
                                echo '<span class="username-span-on-comment"><i class="fa-solid fa-user" style="font-size:0.9rem;"></i> @' . $val->username .' </span>';
                            }

                            echo '</span>&nbsp;&nbsp;<span class="comment-body">' . $val->comment . '</span><br><span class="comment-footer text-muted">' . short_time_since($val->date) . '&nbsp; <span class="reply-to-reply-button" data-comment-id="' . $commentsArray[0]->id . '" data-post-id="' . $row["id"] . '" data-username="' . $val->username . '">Reply</span></span></div>';

                        }

                        echo "</div>";
                    }
                } else {
                    echo "<span class='view-comments text-muted' data-post-id=" . $row["id"] . ">View " . count($commentsArray) . " comments";
                    echo "</span>";
                    echo "<div class='commentSection' style='display:none;' data-post-id=" . $row["id"] . ">";
                    echo "</div>";

                }
            }
        }
    }

    function time_since($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {            
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    function short_time_since($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'y',
            'm' => 'months',
            'w' => 'w',
            'd' => 'd',
            'h' => 'h',
            'i' => 'm',
            's' => 's',
        );
        foreach ($string as $k => &$v) {            
            if ($diff->$k) {
                $v = $diff->$k . $v;
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) : 'just now';
    }


    function outputDate($row) {
        $pieces = explode(" ", time_since($row["date"]));
        if ($pieces[1] == "second" || $pieces[1] == "seconds" || $pieces[1] == "minute" || $pieces[1] == "minutes" || $pieces[1] == "hour" || $pieces[1] == "hours" || $pieces[1] == "day" || $pieces[1] == "days") {
            echo '<br><p class="datetime" style="font-size:0.8rem">' . time_since($row["date"]) . '</p>';
        } else {
            $date = strtotime($row["date"]);
            echo "<br><p class='datetime' style='font-size:0.8rem'>" . date("M jS, Y", $date) . "</p>";
        }
    }


    if (isset($_GET["function"])) {

        if ($_GET["function"] == "logout") {

            unset($_COOKIE['id']);
            setcookie('id', '', time() - 3600, '/'); // empty value and old timestamp
            session_unset();
        }

        if ($_GET["function"] == "yourCommunities") {
            $output = "";
            $output .= '<strong style="color:rgba(0,0,0,0.8);">Your Communities:</strong>
                <hr style="margin-top:5px; margin-bottom:5px;">';
            if(isset($_COOKIE['id'])) {
              //user is logged in

              $query = "SELECT * FROM `groupfollowers` WHERE `userid`='" . mysqli_real_escape_string($link, $_COOKIE['id']) . "'";
              $result = mysqli_query($link, $query);

              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  $groupid = $row["groupid"];
                  $query2 = "SELECT * from `groups` WHERE `id`='". mysqli_real_escape_string($link, $groupid) . "' ORDER BY name ASC";
                  $result2 = mysqli_query($link, $query2);
                  if ($groupRow = mysqli_fetch_assoc($result2)) {
                    $groupName = $groupRow["name"];
                    $output .= "<li class='dropdown-item teaYourGroups'>" . $groupName . "</li>";     
                                
                  }
                 }

               } else {
                $output = "You can follow communities by clicking the follow button on posts :)";
               }

            } else {
              //user is not logged in
              $output = "Let's login to follow communities!";
            }

            echo $output;

        }

    }



    function logout() {
        unset($_COOKIE['id']);
        setcookie('id', '', time() - 3600, '/'); // empty value and old timestamp
        session_unset();
    }

    function algorithm($row) {

        if ($row["likes"] == 0 && $row["downvotes"] >= 0) {
            $downvoteRatio = 2;
        } else {
            $downvoteRatio = $row["downvotes"] / $row["likes"];
        }

        if ($row["downvotes"] >= 5) {
            if ($downvoteRatio >= 2) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 1;
        }
    }

    //post Header and body
    function followingPosts($link, $row, $groupid) {

        if (isset($_COOKIE["id"])) $userid = $_COOKIE["id"];

        if (algorithm($row)) {


            $groupNameQuery = "SELECT * FROM `groups` WHERE `id`='" . $groupid . "'";
            $groupNameResult = mysqli_query($link, $groupNameQuery);
            $groupNameRow = mysqli_fetch_assoc($groupNameResult);

            $groupName = $groupNameRow["name"];
            $postid = $row["id"];

            echo '<div class="card" id="'. $row["id"]. '">
                  <div class="card-header"><a href="/explore?group=' . $groupid . '"><h5 class="card-title" style="display:inline; float:left; margin-top:6px; margin-bottom:0px; position:relative; top:3px;"><i class="fa-solid fa-user-group" style="color:#f5f5f5; display:inline;"></i>&nbsp;&nbsp;' 
                      . $groupName . 
                      '</h5></a>';
            echo '<button type="button" class="follow-button btn btn-outline-secondary" data-btn-groupid="'. $groupid . '">Unfollow</button></div>
                  <div class="card-body-inline-block" data-post-id="' . $postid . '">
                    <p class="card-text">' . $row["content"] . '</p>
                  </div>
                  <div class="card-footer text-muted">';

            $likeQuery = "SELECT * FROM `likes` WHERE `postid`='" . $postid . "' AND `userid`='" . $userid . "'";

            $likeResult = mysqli_query($link, $likeQuery);

                if (mysqli_num_rows($likeResult) > 0) {
                    echo '<i class="fa-solid fa-heart red" data-post-id=' . $postid . '></i>';

                    
                } else {
                    //user has not liked the post, so add the like
                        echo '<i class="fa-regular fa-heart" data-post-id=' . $postid . '></i>';
                    
                }
                
                echo '<i class="fa-regular fa-comment" data-post-id="' . $row["id"] . '"></i><i class="fa-solid fa-share-from-square" data-group-id=' . $groupid . ' data-post-id=' . $postid . '></i>';


                $downvoteQuery = "SELECT * FROM `downvotes` WHERE `postid`='" . $postid . "' AND `userid`='" . $userid . "'";

                $downvoteResult = mysqli_query($link, $downvoteQuery);

                if (mysqli_num_rows($downvoteResult) > 0) {

                    //user has downvoted post

                    echo '<i class="fa-solid fa-thumbs-down blue" data-post-id=' . $postid . '></i>';

                } else {

                    //user has not downvoted post
                    echo '<i class="fa-regular fa-thumbs-down" data-post-id=' . $postid . '></i>';
                                
                }

                echo '<p class="buttons-footer"><span class="likeCount" data-post-id="' . $postid . '">';
                echo '<span class="likeNumber"  data-post-id="' . $postid . '">';
                echo $row["likes"];
                echo "&nbsp;</span>";
                echo "<span class='likeText' data-post-id='" . $postid . "'>";
                echo '</span><span class="downvoteCount" data-post-id="' . $postid . '">';
                echo '<span class="downvoteNumber"  data-post-id="' . $postid . '">';
                echo $row["downvotes"];
                echo "</span>";
                echo ($row["downvotes"] == 1) ? " downvote" : " downvotes";
                echo '</span></p>';

                commentSection($row);

                commentBox($row);

                outputDate($row);

                echo '</div></div>';
        }

    }

    function showGeneralTea($link, $userid) {
        $query = "SELECT * FROM `tea` ORDER BY `date` DESC";
        $result = mysqli_query($link, $query);


        echo '<div class="alert alert-primary card-like-el" style="text-align:center; " role="alert"><h5>Showing You</h5>
          <h2>All Tea</h2>
        </div>';

        while ($row = mysqli_fetch_assoc($result)) {

            if (algorithm($row)) {
                $postid = $row["id"];
                $groupid = $row["groupid"];
                $groupNameQuery = "SELECT * FROM `groups` WHERE `id`='" . $groupid . "' ";
                $groupNameResult = mysqli_query($link, $groupNameQuery);
                $groupName = mysqli_fetch_assoc($groupNameResult)["name"];

                if (isset($userid)) {
                    echo '<div class="card" id="'. $row["id"]. '">
                          <div class="card-header"><a href="/explore?group=' . $groupid . '"><h5 class="card-title" style="display:inline; float:left; margin-top:6px; margin-bottom:0px; position:relative; top:3px;"><i class="fa-solid fa-user-group" style="color:#f5f5f5; display:inline;"></i>&nbsp;&nbsp;' 
                              . $groupName . 
                              '</h5></a>';


                    $followerQuery = "SELECT * FROM `groupfollowers` WHERE `userid`='" . $userid . "' AND `groupid`='" . $groupid . "'";
                    $followerResult = mysqli_query($link, $followerQuery);
                    if (mysqli_num_rows($followerResult) > 0) {

                        echo '<button type="button" class="follow-button btn btn-outline-secondary" data-btn-groupid="'. $groupid . '">Unfollow</button>';
                    } else {
                        echo '<button type="button" class="follow-button btn btn-outline-primary" data-btn-groupid="'. $groupid . '">Follow</button>';
                    }

                    echo '</div>
                          <div class="card-body-inline-block" data-post-id="' . $postid . '">
                            <p class="card-text">' . $row["content"] . '</p>
                          </div>
                          <div class="card-footer text-muted">';

                    $likeQuery = "SELECT * FROM `likes` WHERE `postid`='" . $postid . "' AND `userid`='" . $userid . "'";

                    $likeResult = mysqli_query($link, $likeQuery);

                        if (mysqli_num_rows($likeResult) > 0) {
                            echo '<i class="fa-solid fa-heart red" data-post-id=' . $postid . '></i>';

                            
                        } else {
                            //user has not liked the post, so add the like
                                echo '<i class="fa-regular fa-heart" data-post-id=' . $postid . '></i>';
                            
                        }
                        
                        echo '<i class="fa-regular fa-comment" data-post-id="' . $row["id"] . '"></i><i class="fa-solid fa-share-from-square" data-group-id=' . $groupid . ' data-post-id=' . $postid . '></i>';


                        $downvoteQuery = "SELECT * FROM `downvotes` WHERE `postid`='" . $postid . "' AND `userid`='" . $userid . "'";

                        $downvoteResult = mysqli_query($link, $downvoteQuery);

                        if (mysqli_num_rows($downvoteResult) > 0) {

                            //user has downvoted post

                            echo '<i class="fa-solid fa-thumbs-down blue" data-post-id=' . $postid . '></i>';

                        } else {

                            //user has not downvoted post
                            echo '<i class="fa-regular fa-thumbs-down" data-post-id=' . $postid . '></i>';
                                        
                        }

                        echo '<p class="buttons-footer"><span class="likeCount" data-post-id="' . $postid . '">';
                        echo '<span class="likeNumber"  data-post-id="' . $postid . '">';
                        echo $row["likes"];
                        echo "&nbsp;</span>";
                        echo "<span class='likeText' data-post-id='" . $postid . "'>";
                        echo '</span><span class="downvoteCount" data-post-id="' . $postid . '">';
                        echo '<span class="downvoteNumber"  data-post-id="' . $postid . '">';
                        echo $row["downvotes"];
                        echo "</span>";
                        echo ($row["downvotes"] == 1) ? " downvote" : " downvotes";
                        echo '</span></p>';

                        commentSection($row);

                        commentBox($row);

                        outputDate($row);

                        echo '</div></div>';

                } else {
                    //not logged in

                    echo '<div class="card" id="'. $row["id"]. '">
                          <div class="card-header"><a href="/explore?group=' . $groupid . '"><h5 class="card-title" style="display:inline; float:left; margin-top:6px; margin-bottom:0px; position:relative; top:3px;"><i class="fa-solid fa-user-group" style="color:#f5f5f5; display:inline;"></i>&nbsp;&nbsp;' 
                              . $groupName . 
                              '</h5></a>';

                    echo '<button type="button" class="follow-button btn btn-outline-primary" data-btn-groupid="'. $groupid . '">Follow</button>';
                    echo '</div>
                          <div class="card-body-inline-block" data-post-id="' . $postid . '">
                            <p class="card-text">' . $row["content"] . '</p>
                          </div>
                          <div class="card-footer text-muted">';

                    echo '<i class="fa-regular fa-heart" data-post-id=' . $postid . '></i>';
                            
                
                        
                    echo '<i class="fa-regular fa-comment" data-post-id="' . $row["id"] . '"></i><i class="fa-solid fa-share-from-square" data-group-id=' . $groupid . ' data-post-id=' . $postid . '></i>';

                    echo '<i class="fa-regular fa-thumbs-down" data-post-id=' . $postid . '></i>';
                                       
                    echo '<p class="buttons-footer"><span class="likeCount" data-post-id="' . $postid . '">';
                    echo '<span class="likeNumber"  data-post-id="' . $postid . '">';
                    echo $row["likes"];
                    echo "</span>";
                    echo ($row["likes"] == 1) ? " like" : " likes";
                    echo '</span><span class="downvoteCount" data-post-id="' . $postid . '">';
                    echo $row["downvotes"];
                    echo '<span class="downvoteNumber"  data-post-id="' . $postid . '">';
                    echo ($row["downvotes"] == 1) ? " downvote" : " downvotes";
                        echo '</span></p>';

                    commentSection($row);

                    commentBox($row);

                    outputDate($row);

                        echo '</div></div>';
                }
            }

            inFeedAdUnit();

        }

    }

    function getTea($link, $isLoggedIn, $userid) {

        if ($isLoggedIn) {
            //check if user is following groups
            $query = "SELECT * FROM `groupfollowers` WHERE `userid`='" . $userid . "'";
            $result = mysqli_query($link, $query);
            if (mysqli_num_rows($result) > 0) {
                echo '<div class="alert alert-primary card-like-el" style="text-align:center; " role="alert"><h5>Showing You</h5>
                      <h2>Your Feed</h2>
                    </div>';

                //user is following groups; display only the posts of groups they are following
                while ($row = mysqli_fetch_assoc($result)) {
                    //loop through results to find all groups that user is following
                    $groupid = $row["groupid"];
                    $query = "SELECT * FROM `tea` WHERE `groupid`='" . $groupid . "' ORDER BY `date` DESC";
                    $result = mysqli_query($link, $query);
                    while($row = mysqli_fetch_assoc($result)) {

                        followingPosts($link, $row, $groupid, true);
                       


                    }
                }
            } else {
                //user is not following groups; show all tea
                showGeneralTea($link, $userid);
            }

        } else {
            //display all tea
            showGeneralTea($link, null);
            
        }

    }


    //display explore tea posts
    function explorePage($link, $groupid, $userid) {

        $groupNameQuery = "SELECT * FROM `groups` WHERE `id`='" . $groupid . "' ";
        $groupNameResult = mysqli_query($link, $groupNameQuery);
        $groupName = mysqli_fetch_assoc($groupNameResult)["name"];

        echo '<div class="alert alert-primary card-like-el" style="text-align:center; " role="alert"><h5>The Community of</h5>
          <h2>' . $groupName . '</h2>
        </div>';

        $query = "SELECT * FROM `tea` WHERE `groupid`='" . $groupid . "' ORDER BY `date` DESC";
        $result = mysqli_query($link, $query);

        if (mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

            if (algorithm($row)) {
                $postid = $row["id"];
                $groupid = $row["groupid"];
                

                if (isset($userid)) {
                    echo '<div class="card" id="'. $row["id"]. '">
                          <div class="card-header"><a href="/explore?group=' . $groupid . '"><h5 class="card-title" style="display:inline; float:left; margin-top:6px; margin-bottom:0px; position:relative; top:3px;"><i class="fa-solid fa-user-group" style="color:#f5f5f5; display:inline;"></i>&nbsp;&nbsp;' 
                              . $groupName . 
                              '</h5></a>';


                    $followerQuery = "SELECT * FROM `groupfollowers` WHERE `userid`='" . $userid . "' AND `groupid`='" . $groupid . "'";
                    $followerResult = mysqli_query($link, $followerQuery);
                    if (mysqli_num_rows($followerResult) > 0) {

                        echo '<button type="button" class="follow-button btn btn-outline-secondary" data-btn-groupid="'. $groupid . '">Unfollow</button>';
                    } else {
                        echo '<button type="button" class="follow-button btn btn-outline-primary" data-btn-groupid="'. $groupid . '">Follow</button>';
                    }

                    echo '</div>
                          <div class="card-body-inline-block" data-post-id="' . $postid . '">
                            <p class="card-text">' . $row["content"] . '</p>
                          </div>
                          <div class="card-footer text-muted">';

                    $likeQuery = "SELECT * FROM `likes` WHERE `postid`='" . $postid . "' AND `userid`='" . $userid . "'";

                    $likeResult = mysqli_query($link, $likeQuery);

                        if (mysqli_num_rows($likeResult) > 0) {
                            echo '<i class="fa-solid fa-heart red" data-post-id=' . $postid . '></i>';

                            
                        } else {
                            //user has not liked the post
                                echo '<i class="fa-regular fa-heart" data-post-id=' . $postid . '></i>';
                            
                        }
                        
                        echo '<i class="fa-regular fa-comment" data-post-id="' . $row["id"] . '"></i><i class="fa-solid fa-share-from-square" data-group-id=' . $groupid . ' data-post-id=' . $postid . '></i>';


                        $downvoteQuery = "SELECT * FROM `downvotes` WHERE `postid`='" . $postid . "' AND `userid`='" . $userid . "'";

                        $downvoteResult = mysqli_query($link, $downvoteQuery);

                        if (mysqli_num_rows($downvoteResult) > 0) {

                            //user has downvoted post

                            echo '<i class="fa-solid fa-thumbs-down blue" data-post-id=' . $postid . '></i>';

                        } else {

                            //user has not downvoted post
                            echo '<i class="fa-regular fa-thumbs-down" data-post-id=' . $postid . '></i>';
                                        
                        }

                        echo '<p class="buttons-footer"><span class="likeCount" data-post-id="' . $postid . '">';
                        echo '<span class="likeNumber"  data-post-id="' . $postid . '">';
                        echo $row["likes"];
                        echo "&nbsp;</span>";
                        echo "<span class='likeText' data-post-id='" . $postid . "'>";
                        echo '</span><span class="downvoteCount" data-post-id="' . $postid . '">';
                        echo '<span class="downvoteNumber"  data-post-id="' . $postid . '">';
                        echo ($row["downvotes"] == 1) ? " downvote" : " downvotes";
                            echo '</span></p>';

                        commentSection($row);
                        commentBox($row);

                        outputDate($row);

                        echo '</div></div>';

                } else {
                    //not logged in

                    echo '<div class="card" id="'. $row["id"]. '">
                          <div class="card-header"><a href="/explore?group=' . $groupid . '"><h5 class="card-title" style="display:inline; float:left; margin-top:6px; margin-bottom:0px; position:relative; top:3px;"><i class="fa-solid fa-user-group" style="color:#f5f5f5; display:inline;"></i>&nbsp;&nbsp;' 
                              . $groupName . 
                              '</h5></a>';

                    echo '<button type="button" class="follow-button btn btn-outline-primary" data-btn-groupid="'. $groupid . '">Follow</button>';
                    echo '</div>
                          <div class="card-body-inline-block" data-post-id="' . $postid . '">
                            <p class="card-text">' . $row["content"] . '</p>
                          </div>
                          <div class="card-footer text-muted">';

                    echo '<i class="fa-regular fa-heart" data-post-id=' . $postid . '></i>';
                            
                
                        
                    echo '<i class="fa-regular fa-comment" data-post-id="' . $row["id"] . '"></i><i class="fa-solid fa-share-from-square" data-group-id=' . $groupid . ' data-post-id=' . $postid . '></i>';

                    echo '<i class="fa-regular fa-thumbs-down" data-post-id=' . $postid . '></i>';
                                       
                    echo '<p class="buttons-footer"><span class="likeCount" data-post-id="' . $postid . '">';
                    echo '<span class="likeNumber"  data-post-id="' . $postid . '">';
                    echo $row["likes"];
                    echo "</span>";
                    echo ($row["likes"] == 1) ? " like" : " likes";
                    echo '</span><span class="downvoteCount" data-post-id="' . $postid . '">';
                    echo '<span class="downvoteNumber"  data-post-id="' . $postid . '">';
                    echo ($row["downvotes"] == 1) ? " downvote" : " downvotes";
                            echo '</span></p>';

                    commentSection($row);

                    commentBox($row);

                    outputDate($row);

                    echo '</div></div>';
                }
            }

        } 
    } else {
        //no posts in this group
        echo '<div class="alert alert-dark card-like-el" role="alert">
              Oops! Seems like there aren&#39;t any posts in this community yet. <br><a href="#confess" class="text-secondary">Why not be the first to share?</a>
            </div>';
    }



    }



    


?>