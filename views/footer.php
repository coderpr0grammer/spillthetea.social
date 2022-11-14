
  <footer class="footer">
      <div class="container">
        <!-- <span style="color: #111111;">Credit to © <a style="color: #000000;" href='https://www.123rf.com/profile_captainvector'>captainvector</a>, <a style="color: #000000;" href='https://www.123rf.com/free-images/'>123RF Free Images</a> for the Cup in our Logo</span> -->
      </div>
  </footer>
  
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>


    <script>

      $(".navbar-toggler").click(function() {
        var collapsed = $(this).hasClass("collapsed");
        console.log(collapsed)
        if (collapsed) {
          $(this).css("box-shadow", "0px 2px 10px 1px rgb(0 0 0 / 80%)");
        } else {
          $(this).css("box-shadow", "0px 2px 10px 1px rgb(0 0 0 / 80%) inset");
        }
      })

      var autocompleteData = [];
      window.onload = function() {

        viewportAdjustments();

        $.get("/autocomplete.php", "").done(function(data) {
          parsedData = JSON.parse(data);
          console.log(parsedData);
          parsedData.forEach(function(index, item) {
            autocompleteData.push(index.value)
          })
          console.log(autocompleteData)
        })
        
        
      }


/*
      $("#confessModalSearch").change(function () {
        console.log("change");
          if (document.querySelector('.ui-autocomplete').style.display == "none") {
            alert("hello")
            
          } else {
            alert("bye")
            $(".dropdown-menu").removeClass("show");
            
          }
      })
      */

      $("#toggleMenuIcon").click(function() {
        if ($(this).hasClass("fa-chevron-up")) {
          $(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
        } else {
          $(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
        }
      })


      $(document).ready(function() {

        if (window.clientWidth >= 500) {
          //on pc
          $("#toggleMenuIcon").removeClass("fa-chevron-up").addClass("fa-chevron-down");
        } else {
          //on mobile
          
          $("#toggleMenuIcon").removeClass("fa-chevron-down").addClass("fa-chevron-down");
        }
        

        if(window.location.href.indexOf('#confess') != -1) {
          $('#confess').modal("show");
        }

        $(".likeNumber").each(function(el) {
          if (parseInt($(this).html()) == 1) {
            $(".likeText[data-post-id=" + $(this).attr("data-post-id") + "]").html("like");
          } else {
            $(".likeText[data-post-id=" + $(this).attr("data-post-id") + "]").html("likes");
          }
        })

        $(".verified-badge").each(function(index) {

        })


      });

      $("a").click(function() {

        if(window.location.href.indexOf('#confess') != -1) {
          $('#confess').modal('show');
        }


      });

      $('a[href*="#confess"]').on("click", function() {
        $("#confess").modal("show");
      })

       $(document).on("click", ".reply-button", function() {
         if ($("#usernameSpan").html() != undefined) {
            var postid = $(this).attr("data-post-id");
            console.log(postid)
            var replyingToUsername = $(this).attr("data-username");
            var commentID = $(this).attr("data-comment-id");
            $(".comment-box[data-post-id=" + postid + "]").val("@" + replyingToUsername + " ").focus();
            $(".replyingToText[data-post-id=" + postid + "]").html(replyingToUsername);
            $(".replyingTo[data-post-id=" + postid + "]").val(commentID);
            $(".replyingToDiv[data-post-id=" + postid + "]").show();
            $(".comment-form[data-post-id=" + postid + "]").addClass("d-flex");
            $(".comment-form[data-post-id=" + postid + "]").slideDown( "slow");
            
            // alert(commentValue);
          } else {
            fancyAlert("success", "Please login to post comments :)");
          }

            
          })

       $(document).on("click", ".reply-to-reply-button", function() {
         if ($("#usernameSpan").html() != undefined) {
            var postid = $(this).attr("data-post-id");
            console.log(postid)
            var replyingToUsername = $(this).attr("data-username");
            $(".comment-box[data-post-id=" + postid + "]").val("@" + replyingToUsername + " ").focus();
            $(".replyingTo[data-post-id=" + postid + "]").val($(this).attr("data-comment-id"))
            $(".replyingToText[data-post-id=" + postid + "]").html(replyingToUsername);
            $(".replyingToDiv[data-post-id=" + postid + "]").show();
            $(".comment-form[data-post-id=" + postid + "]").addClass("d-flex");
            $(".comment-form[data-post-id=" + postid + "]").slideDown( "slow");
            
            // alert(commentValue);
          } else {
            fancyAlert("success", "Please login to post comments :)");
          }

            
          })

       

      function fancyAlert(type, message) {
        $("#fancy-alert-text").html(message);

        if (type == "success") {
          $("#fancy-alert").removeClass("alert-danger").addClass("alert-sucess");
        } else {
          $("#fancy-alert").addClass("alert-danger").removeClass("alert-sucess");
        }

        $("#fancy-alert").animate({
            opacity: 1,
            top: "15px"
          }, 600)

      }

      $("#fancy-alert-close").click (function() {
        $("#fancy-alert").animate({
            opacity: 0,
            top: "-100px"
          }, 600)
      })


      function viewportAdjustments() {



        var vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0)
        var vh = Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0)
        if (vw <= 500) {
          $(".nav-item:nth-child(2)").css("margin-left", "0px");
          //if on mobile (phone)

          // $("#searchbar-nav-item").css("order", "1");
          $("#userProfileIcon").addClass("usernameSectionMobile")
          $(".nav-item").css("margin-top", "5px");
          $("#searchNavItem").css ("width", "100%");
          $("#searchForm").css ("min-width", "93vw");
          $(".navbar").addClass("fixed-bottom");
          $(".navbar").addClass("mobile-nav-bg");
          // $(".card").css("height", "60vh");
          $(".card").css("max-width", "");
          $(".card-like-el").css("max-width", "")
          $(".card-footer").css("min-height", "20vh");
          $(".support-dev-link").css("display", "block");
          $(".support-dev-link").css("border", "1px solid #DF6431");
          $("#loginSignupButton").css("width", "100%");
          $("#searchNavItem").css('order', "1")

          $(".mobile-show").each(function(index) {
            $(this).addClass("btn btn-nav");
          })
          



        } else {

            if ($(".navbar-collapse").hasClass("show")) {
              $(".nav-item:nth-child(2)").css("margin-left", "10px");
            } else {
              $(".nav-item:nth-child(2)").css("margin-left", "0px");
            }
            $("#loginSignupButton").css("width", "");
            $("#searchNavItem").css('order', "3")
            $("#searchNavItem").css ("width", "");
            // $(".card").css("height", "30vh");
            $(".card").css("max-width", "60vh");
            $("#searchForm").css ("min-width", "45vw");
            $(".support-dev-link").css("display", "inline-block");
            $(".support-dev-link").css("padding-right", "8px");
            // $("#searchForm").css ("width", "calc(100%-200px)");
            $(".navbar").removeClass("mobile-nav-bg");
            $(".card-footer").css("min-height", "20vh");
            $(".card-like-el").css("max-width", "60vh")

            
            if ($(".navbar").hasClass("fixed-bottom")) {

              $(".navbar").removeClass("fixed-bottom");

            }
            $(".mobile-show").each(function(index) {
              $(this).removeClass("btn btn-nav");
            })

            // if (window.scrollY > 10) {
            //   $(".navbar").addClass("mobile-nav-bg");
            // } else {
            //   $(".navbar").removeClass("mobile-nav-bg");
            // }

        }

        

      }

      // window.addEventListener("scroll", (event) => {
      //   var vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0)
      //   var vh = Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0)
      //   if (vw >= 500) {
      //     let scroll = this.scrollY;
      //     if (scroll > 10) {
      //       $(".navbar").addClass("mobile-nav-bg");
      //     } else {
      //       $(".navbar").removeClass("mobile-nav-bg");
      //     }
      //   }
      // });


        window.addEventListener("resize", () => {

          viewportAdjustments();
        });
      
      

      


    </script>


  <script type="text/javascript">

    $(".ui-autocomplete").css("z-index", "30");

    //slide animation for dropdown

    $('.dropdown').on('show.bs.dropdown', function() {
    $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
  });

  // Add slideUp animation to Bootstrap dropdown when collapsing.
  $('.dropdown').on('hide.bs.dropdown', function() {
    $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
  });

    $("#loginSignupToggle").click(function() {
      console.log($("#isLoggingIn").val())
      if ($("#isLoggingIn").val() == 1) {
        $("#loginSignupToggle").html("Log In");
        $("#loginTitle").html("Signup");
        $("#loginButton").html("Sign Up");
        $("#isLoggingIn").val("0");
      } else {
        $("#loginSignupToggle").html("Sign Up");
        $("#loginTitle").html("Log In");
        $("#loginButton").html("Login");
        $("#isLoggingIn").val("1");
      }
    })

    $("#registerGroupForm").submit(function(e) {
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: "/actions.php?action=registerGroup",
        data: "name=" + $("#groupName").val() + "&description=" + $("#groupDescription").val(),
        success: function(result) {
          var parsed = JSON.parse(result);
          if (parsed.response == "1") {
            $("#registrationError").hide();
            $("#registrationSuccess").show();
            $("#groupDetails").html(parsed.name);
            $("#sharing-link").html("<a id='sharing-link-link' class='btn btn-primary' href='#' data-sharing-link='/explore?group=" + parsed.id + "'><i class='fa-solid fa-link'></i> Copy the Sharing Link</a>")
          } else {
            $("#registrationError").html(parsed.error);
            $("#registrationError").show();
          }
        }
      })
    })

    $("#sharing-link").click(function() {
      console.log("hi")
      var sharingLink = "https://spillthetea.social" + $("#sharing-link-link").attr("data-sharing-link")
      navigator.clipboard.writeText(sharingLink);
    })

    //post confession
    $("#submitTeaForm").submit(function(e) {
      e.preventDefault();
      document.getElementById("submitTeaButton").disabled = true;
      $(".loading-icon").show();
      $.ajax({
        type: "POST",
        url: "/actions.php?action=postTea",
        data: "group=" + $("#confessModalSearch").val() + "&content=" + $("#teaTextarea").val(),
        success: function(result) {
          if (result == "1") {
            $("#submitTeaError").hide();
            $("#submitTeaSuccess").show();
          } else {
            $("#submitTeaError").html(result);
            $("#submitTeaError").show();
          }
        }
      })
      $(".loading-icon").hide();
      // document.getElementById("submitTeaButton").disabled = false;
      setTimeout(function() {
        window.location.reload();
      }, 1000)
      
    })

    $("#loginSignupForm").submit(function(e) {
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: "/actions.php?action=loginSignup",
        data: "username=" + $("#usernameInput").val() + "&password=" + $("#passwordInput").val() + "&isLoggingIn=" + $("#isLoggingIn").val() + "&stayLoggedIn=" + $("#stayLoggedInInput").val(),
        success: function(result) {
          console.log(result);
          if (result == "2") {
            $("#loginError").hide();
            $("#loginSuccess").show();

            setTimeout(function() {
              window.location.reload();
              $("#loginSuccess").hide();
            }, 2000)


          } else if (result == "1") {
            $("#loginError").html(result).hide();
            $("#signupSuccess").show();
            setTimeout(function() {
              window.location.reload();
              $("#signupSuccess").hide();
            }, 2000)
          } else {
            $("#loginError").html(result).show();
          }
        }
      })
      
    })

    $("#logoutButton").click(function() {
      $.ajax({
        type: "POST",
        url: "/actions.php?action=logout",
        data: "username=" + $("#usernameSpan").html(),
        success: function(result) {
          console.log(result);
          if (result == "1") {
            setTimeout(function() {
              window.location.reload();
              $("#loginSuccess").hide();
            }, 1)

          } else {
            fancyAlert("error", result);
          }
        }
      })
    })


$(document).ready(function() {
    
  $( "#navbarSearch" ).autocomplete({
    source: autocompleteData,
    autoFocus: true,
    minLength: 2,
    position: {  collision: "flip"  }
    
  });

});

$(document).ready(function() {
    
  $( "#confessModalSearch" ).autocomplete({
    source: autocompleteData,
    autoFocus: true

  });

});

//autocomplete your communities
$('li.teaYourGroups').on('click', function(e) {
  // $(".teaYourGroups").click(function(e) {
    e.preventDefault();
    $("#confessModalSearch").val($(this).html());
    // console.log($(this).html());
  // })
});

$(".dropdown-item").click(function() {
  console.log("hi");
})



//     $(function() {
//     $("#navbarSearch").autocomplete({
//         source: "autocomplete.php",
//         select: function( event, ui ) {
//             event.preventDefault();
//             $("#skill_input").val(ui.item.id);
//         }
//     });
// });

  //follow group 

  $(".follow-button").click(function() {
    var el = $(this);
    var selectAllBtnsWithData = $('*[data-btn-groupid="' + el.attr("data-btn-groupid") + '"]');
    if($("#usernameSpan").html() != undefined) {
      $.ajax({
          type: "POST",
          url: "/actions.php?action=followUnfollowGroup",
          data: "group=" + el.attr("data-btn-groupid") + "&username=" + $("#usernameSpan").html(),
          success: function(result) {
            if (result == "1") {
              //follow successfull
              selectAllBtnsWithData.html("Unfollow");
              selectAllBtnsWithData.removeClass("btn-outline-primary");
              selectAllBtnsWithData.addClass("btn-outline-secondary");
              // window.location.reload();
            } else if (result == "2") {
              selectAllBtnsWithData.html("Follow");
              selectAllBtnsWithData.removeClass("btn-outline-secondary");
              selectAllBtnsWithData.addClass("btn-outline-primary");
              // window.location.reload();
            } else {
              fancyAlert("error", result);
            }
        }
      })
    } else {
      fancyAlert("error", "Please login to join groups :D");
    }
  })

var getCookieValue = (name) => (
  document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)')?.pop() || ''
)

//share button

$(".fa-share-from-square").click(function() {
  var groupid = $(this).attr("data-group-id");
  var postid = $(this).attr("data-post-id");
  var postUrl = "/explore/?group=" + groupid + "#" + postid;

  var vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0)
  var vh = Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0)
  if (vw <= 500) {

    if (navigator.share) {
      navigator.share({
        title: 'Spill The Tea',
        url: postUrl
      }).then(() => {
        fancyAlert("success", "Thanks for sharing!");
      })
      .catch(console.error);
    } else {
      // fallback
    }

  } else {
    //user is on computer

    // Copy the text inside the text field
    navigator.clipboard.writeText("https://spillthetea.social" + postUrl);
    fancyAlert("success", "Copied the sharing link");

    }
  })

  

  function adjustLikeText(el) {
    console.log("data post id: " + $(el).attr("data-post-id"));
    likeNumberEl = $(".likeNumber[data-post-id=" + $(el).attr("data-post-id") + "]");
    console.log(likeNumberEl)
    var numberOfLikes = parseInt( likeNumberEl.html() );
    console.log("# of likes " + numberOfLikes);
    if (numberOfLikes == 1) {
            $(".likeText[data-post-id=" + $(el).attr("data-post-id") + "]").html(" like");
          } else {
            $(".likeText[data-post-id=" + $(el).attr("data-post-id") + "]").html(" likes");
          }
  }


  $(".fa-heart").click(function() {
    if($("#usernameSpan").html() != undefined) {
      var likeToAdd = $(this).attr("data-post-id");
      var el = $(this);
      if (el.hasClass("red")) {
        el.removeClass("fa-solid");
        el.removeClass("red");
        el.addClass("fa-regular");
        var likeCount = parseInt($(".likeNumber[data-post-id=" + $(this).attr("data-post-id") + "]").html());
        $(".likeNumber[data-post-id=" + $(this).attr("data-post-id") + "]").html(likeCount -1);
        adjustLikeText(this);


      } else {

            if ($(".fa-thumbs-down[data-post-id=" + $(this).attr("data-post-id") + "]").hasClass("blue")) {
              var downvoteNumber = parseInt($(".downvoteNumber[data-post-id=" + $(this).attr("data-post-id") + "]").html());
              $(".downvoteNumber[data-post-id=" + $(this).attr("data-post-id") + "]").html(downvoteNumber - 1);
            }

            $(".fa-thumbs-down[data-post-id=" + $(this).attr("data-post-id") + "]").removeClass("fa-solid").removeClass("blue").addClass("fa-regular");
            el.addClass("fa-solid");
            el.addClass("red");

            el.animate({
              fontSize: "1.4rem"
            }, 100)

            el.animate({
              fontSize: "1.5rem"
            }, 100)            
            
            el.removeClass("fa-regular");
            var likeCount = parseInt($(".likeNumber[data-post-id=" + $(this).attr("data-post-id") + "]").html());
            $(".likeNumber[data-post-id=" + $(this).attr("data-post-id") + "]").html(likeCount + 1);

            adjustLikeText(this);

      }
      $.ajax({
        type: "POST",
        url: "/actions.php?action=like",
        data: "postid=" + likeToAdd + "&username=" + $("#usernameSpan").html(),
        success: function(result) {
          if (result == "1") {
            // el.addClass("fa-solid");
            // el.addClass("red");
            // el.removeClass("fa-regular");
          } else if (result == "2") {
            // el.removeClass("fa-solid");
            // el.removeClass("red");
            // el.addClass("fa-regular");
          } else {
            fancyAlert("error", "We encountered an issue, please contact support to let us know.");
          }
          console.log(result);
        }
      })
    } else {
      fancyAlert("success", "Please login to like posts :)");
    }

    // $(this).animate()
    // if (getCookieValue("id") != "") {
    //   // alert("logged in ");

    // } else {
    //   alert("not logged in")
    // }
    

  })


  $(".card-body-inline-block").dblclick(function() {
    if($("#usernameSpan").html() != undefined) {
      var postid = $(this).attr("data-post-id");
      var likeToAdd = $(this).attr("data-post-id");

      el = $(".fa-heart[data-post-id='" + postid + "']");

      if (!el.hasClass("red")) {
        if ($(".fa-thumbs-down[data-post-id=" + $(this).attr("data-post-id") + "]").hasClass("blue")) {
                var downvoteNumber = parseInt($(".downvoteNumber[data-post-id=" + $(this).attr("data-post-id") + "]").html());
                $(".downvoteNumber[data-post-id=" + $(this).attr("data-post-id") + "]").html(downvoteNumber - 1);
              }

              $(".fa-thumbs-down[data-post-id=" + $(this).attr("data-post-id") + "]").removeClass("fa-solid").removeClass("blue").addClass("fa-regular");
              el.addClass("fa-solid");
              el.addClass("red");

              el.animate({
                fontSize: "1.4rem"
              }, 100)

              el.animate({
                fontSize: "1.5rem"
              }, 100)            
              
              el.removeClass("fa-regular");
              var likeCount = parseInt($(".likeNumber[data-post-id=" + $(this).attr("data-post-id") + "]").html());
              $(".likeNumber[data-post-id=" + $(this).attr("data-post-id") + "]").html(likeCount + 1);

              adjustLikeText(this);
      } else {
        el.animate({
                fontSize: "1.4rem"
              }, 100)

              el.animate({
                fontSize: "1.5rem"
              }, 100)         
      }

      $.ajax({
          type: "POST",
          url: "/actions.php?action=like",
          data: "postid=" + likeToAdd + "&username=" + $("#usernameSpan").html(),
          success: function(result) {
            if (result == "1") {
              // el.addClass("fa-solid");
              // el.addClass("red");
              // el.removeClass("fa-regular");
            } else if (result == "2") {
              // el.removeClass("fa-solid");
              // el.removeClass("red");
              // el.addClass("fa-regular");
            } else {
              fancyAlert("error", "We encountered an issue, please contact support to let us know.");
            }
            console.log(result);
          }
        })

    } else {
      fancyAlert("success", "Please login to like posts :)");
    }

  })

$(".fa-thumbs-down").click(function() {
    if($("#usernameSpan").html() != undefined) {
      var downvoteToAdd = $(this).attr("data-post-id");
      var el = $(this);
      if (el.hasClass("blue")) {
        el.removeClass("fa-solid");
        el.removeClass("blue");
        el.addClass("fa-regular");
        var downvoteNumber = parseInt($(".downvoteNumber[data-post-id=" + $(this).attr("data-post-id") + "]").html());
        $(".downvoteNumber[data-post-id=" + $(this).attr("data-post-id") + "]").html(downvoteNumber -1);
      } else {

        
        if ($(".fa-heart[data-post-id=" + $(this).attr("data-post-id") + "]").hasClass("red")) {
          var likeNumber = parseInt($(".likeNumber[data-post-id=" + $(this).attr("data-post-id") + "]").html());
          $(".likeNumber[data-post-id=" + $(this).attr("data-post-id") + "]").html(likeNumber -1);
        }
        
        $(".fa-heart[data-post-id=" + $(this).attr("data-post-id") + "]").removeClass("fa-solid").removeClass("red").addClass("fa-regular");
        el.addClass("fa-solid");
            el.addClass("blue");
            el.removeClass("fa-regular");

        var downvoteNumber = parseInt($(".downvoteNumber[data-post-id=" + $(this).attr("data-post-id") + "]").html());
        $(".downvoteNumber[data-post-id=" + $(this).attr("data-post-id") + "]").html(downvoteNumber + 1);

        adjustLikeText(this);

      }
      $.ajax({
        type: "POST",
        url: "/actions.php?action=downvote",
        data: "postid=" + downvoteToAdd + "&username=" + $("#usernameSpan").html(),
        success: function(result) {
          if (result == "1") {
            // el.addClass("fa-solid");
            // el.addClass("red");
            // el.removeClass("fa-regular");
          } else if (result == "2") {
            // el.removeClass("fa-solid");
            // el.removeClass("red");
            // el.addClass("fa-regular");
          } else {
            fancyAlert("error", "We encountered an issue, please contact support to let us know.");
          }
          console.log(result);
        }
      })
    } else {
      fancyAlert("success", "Please login to downvote posts");
    }
    

  })

$("#confessModalSearch").click(function () {
  $.ajax({
    type: "GET",
    url: "/functions.php?function=yourCommunities",
    data: $("#usernameSpan").html(),
    success: function(result) {
      $("#dropdownSearch").html(result);
    }
  })
  
})

$(window).on("load", function() {
  // $(document.body).css("overflow", "hidden")
  setTimeout(function() {$('.preloader').fadeOut('slow'); $(document.body).css("overflow", "visible")}, 1200);
   
});

$('#confess').on('hidden.bs.modal', function () {
    // do something…
    $(document.body).css("overflow", "visible")
});

//search bar

$("#searchForm").submit(function(e) {
    e.preventDefault();
    $.ajax({
      type: "GET",
      url: "/actions.php?action=search",
      data: "searchQuery=" + $("#navbarSearch").val(),
      success: function(result) {
        console.log(result);
        var parsed = JSON.parse(result);
        if (parsed.response == 1) {
          window.location.assign("/explore/?group=" + parsed.groupid);
        } else {
          fancyAlert("success", "Oops! Please select one of the search results :)");
        }
        
      }
    })
    
})


//search get variables

var $_GET = {};
if(document.location.toString().indexOf('?') !== -1) {
    var query = document.location
                   .toString()
                   // get the query string
                   .replace(/^.*?\?/, '')
                   // and remove any existing hash string (thanks, @vrijdenker)
                   .replace(/#.*$/, '')
                   .split('&');

    for(var i=0, l=query.length; i<l; i++) {
       var aux = decodeURIComponent(query[i]).split('=');
       $_GET[aux[0]] = aux[1];
    }
}


if ($_GET["group"] != undefined) {
  $.ajax({
    type: "GET",
    url: "/actions.php?action=getGroup",
    data: "groupid=" + $_GET["group"],
    success: function(result) {
      console.log(result);
      if (result != "0") {
        $("#confessModalSearch").val(result);
      }
    }
  })
  
}

$(".fa-comment").click(function() {

  if ($("#usernameSpan").html() != undefined) {
    var postid = $(this).attr("data-post-id");
    if ($(".comment-form[data-post-id=" + postid + "]").hasClass("d-flex")) {
        $(".comment-form[data-post-id=" + postid + "]").slideUp( "slow", function() {
          $(".comment-form[data-post-id=" + postid + "]").removeClass("d-flex");
        })
        $(".replyingTo[data-post-id=" + postid + "]").val("");
        $(".replyingToText[data-post-id=" + postid + "]").html("");
        $(".replyingToDiv[data-post-id=" + postid + "]").hide();
    } else {
      $(".comment-form[data-post-id=" + postid + "]").addClass("d-flex");
      $(".comment-form[data-post-id=" + postid + "]").slideDown( "slow", function() {
          
      })
    }
  } else {
    fancyAlert("success", "Please login to comment on posts :)")
  }
  
})



$(".closeReplyDialog").click(function() {
  var postid = $(this).attr("data-post-id");
  $(".replyingTo[data-post-id=" + postid + "]").val("");
  $(".replyingToText[data-post-id=" + postid + "]").html("");
  $(".replyingToDiv[data-post-id=" + postid + "]").hide();
})


$(".comment-form").submit(function(e) {
    e.preventDefault();
    var postid = $(this).attr("data-post-id")

    var commentValue = $(".comment-box[data-post-id='" + postid + "']").val();
    var commentButton = ".commentButton[data-post-id='" + postid + "']";
    document.querySelector(commentButton).disabled = true;

    $.ajax({
      type: "POST",
      url: "/actions.php?action=postComment",
      data: "postid=" + postid + "&replyingTo=" + $(".replyingTo[data-post-id='" + postid + "']").val() + "&username=" + $("#usernameSpan").html() + "&content=" + commentValue,
      success: function(result) {
        
        if (result != "0") {
          // JSON.stringify(result)
          $(".comment-box[data-post-id='" + postid + "']").val("");
          fancyAlert("success", "Your comment was successfully posted!");
          console.log(result);
          setTimeout(function() {
            window.location.reload();
          }, 1000)

          

        } else {
          console.log(data)
          fancyAlert("error", "Sorry, there was an issue posting your comment.");
        }

        document.querySelector(commentButton).disabled = false;
      }
    })

})

function verifiedBadge() {
  return '<svg class="verified-badge" fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg"><path clip-rule="evenodd" d="M6.26701 3.45496C6.91008 3.40364 7.52057 3.15077 8.01158 2.73234C9.15738 1.75589 10.8426 1.75589 11.9884 2.73234C12.4794 3.15077 13.0899 3.40364 13.733 3.45496C15.2336 3.57471 16.4253 4.76636 16.545 6.26701C16.5964 6.91008 16.8492 7.52057 17.2677 8.01158C18.2441 9.15738 18.2441 10.8426 17.2677 11.9884C16.8492 12.4794 16.5964 13.0899 16.545 13.733C16.4253 15.2336 15.2336 16.4253 13.733 16.545C13.0899 16.5964 12.4794 16.8492 11.9884 17.2677C10.8426 18.2441 9.15738 18.2441 8.01158 17.2677C7.52057 16.8492 6.91008 16.5964 6.26701 16.545C4.76636 16.4253 3.57471 15.2336 3.45496 13.733C3.40364 13.0899 3.15077 12.4794 2.73234 11.9884C1.75589 10.8426 1.75589 9.15738 2.73234 8.01158C3.15077 7.52057 3.40364 6.91008 3.45496 6.26701C3.57471 4.76636 4.76636 3.57471 6.26701 3.45496ZM13.7071 8.70711C14.0976 8.31658 14.0976 7.68342 13.7071 7.29289C13.3166 6.90237 12.6834 6.90237 12.2929 7.29289L9 10.5858L7.70711 9.29289C7.31658 8.90237 6.68342 8.90237 6.29289 9.29289C5.90237 9.68342 5.90237 10.3166 6.29289 10.7071L8.29289 12.7071C8.68342 13.0976 9.31658 13.0976 9.70711 12.7071L13.7071 8.70711Z" fill="orange" fill-rule="evenodd"/></svg>';
}



$(".view-comments").click(function() {
  var thisel = $(this);
  var postid = $(this).attr("data-post-id");
  if ($(".commentSection[data-post-id='" + postid + "'").css("display") != "block") {
    $.get("/actions.php?action=getComments", "postid=" + postid).done(function(data) {
      var parsedData = JSON.parse(data);
      thisel.attr("data-number-of-comments", parsedData.length); 
      var outputHTML = "";
      // console.log(parsedData)
      parsedData.forEach(function(val) {
        console.log(val)
        console.log(val.verified);
        console.log(typeof(val.verified));
        if (val.verified == 1) {
          console.log(val.username + " is verified");
        }
        outputHTML += '<div class="comment"><span class="comment-user-info" data-comment-username="' + val.username + '">';
        if (val.verified == 1) {
          outputHTML += '<span class="username-span-on-comment verified-user">';
        }
        outputHTML += '<i class="fa-solid fa-user" style="font-size:0.9rem;"></i> @' + val.username + ' ';
        if (val.verified == 1) {
          outputHTML += verifiedBadge();
          outputHTML += ' </span>';
        }
        
        outputHTML += '&nbsp;&nbsp;<span class="comment-body">' + val.comment + '</span>';
        outputHTML += '<br><span class="comment-footer text-muted">' + shortTimeSince(val.date) + '&nbsp; <span class="reply-button" data-comment-id="' + val.id + '" data-post-id="' + postid + '" data-username="' + val.username + '">Reply</span></span></div>';

        if (val.replies.length > 0) {
          val.replies.forEach(function(val2) {
            outputHTML += '<div class="reply"><span style="opacity:0.5;">&mdash;</span><span class="comment-user-info" data-comment-username="' + val2.username + '">';

          if (val.verified == 1) {
            outputHTML += '<span class="username-span-on-comment verified-user">';
          }
          outputHTML += '<i class="fa-solid fa-user" style="font-size:0.9rem;"></i> @' + val2.username + ' ';
          if (val.verified == 1) {
            outputHTML += verifiedBadge();
            outputHTML += ' </span>';
          }
        
          outputHTML += '&nbsp;&nbsp;<span class="comment-body">' + val2.comment + '</span>';
          outputHTML += '<br><span class="comment-footer text-muted">' + shortTimeSince(val2.date) + '&nbsp; <span class="reply-to-reply-button" data-comment-id="' + val.id + '" data-post-id="' + postid + '" data-username="' + val2.username + '">Reply</span></span></div>';
          })

        }
      })
      $(this).attr("data-number-of-comments", parsedData.length); 
      $(this).html("Hide Comments");
      $(".commentSection[data-post-id='" + postid + "']").html(outputHTML).slideDown();
    })
  } else {
    $(".commentSection[data-post-id='" + postid + "']").slideUp();
    $(this).html("Show " + $(this).attr('data-number-of-comments') + " comments");
  }


})

function shortTimeSince(date) {
  // Split timestamp into [ Y, M, D, h, m, s ]
  var t = date.split(/[- :]/);

  // Apply each element to the Date function
  var d = new Date(Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]));

  var seconds = Math.floor((new Date() - d) / 1000);

  var interval = seconds / 31536000;

  console.log(interval);

  if (interval > 1) {
    return Math.floor(interval) + "y";
  }
  interval = seconds / 2592000;
  if (interval > 1) {
    return Math.floor(interval) + "mnths";
  }
  interval = seconds / 86400;
  if (interval > 1) {
    return Math.floor(interval) + "d";
  }
  interval = seconds / 3600;
  if (interval > 1) {
    return Math.floor(interval) + "h";
  }
  interval = seconds / 60;
  if (interval > 1) {
    return Math.floor(interval) + "m";
  }
  return Math.floor(seconds) + " seconds";

}








    </script>


  </body>
</html>