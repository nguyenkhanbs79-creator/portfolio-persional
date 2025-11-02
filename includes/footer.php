  <!-- Boostrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
    crossorigin="anonymous"></script>

  <!--Read More JS credit to https://codingartistweb.com/2020/04/read-more-read-less/-->
  <script>
    $(document).ready(function () {
      $(".read").click(function () {
        $(this).prev().toggle();
        $(this).siblings(".dots").toggle();
        if ($(this).text() == "Xem thêm...") {
          $(this).text("Thu gọn...");
        } else {
          $(this).text("Xem thêm...");
        }
      });
    });
  </script>

  <!---Nav JS-->
  <script>
    $(document).ready(function () {
      $(".second-button").on("click", function () {
        $(".animated-icon2").toggleClass("open");
      });
    });
    //credit to https://codepen.io/imprfcto/pen/WNNpBLp for helping me close nav item when clicked on
    // close hamburger menu after click a
    $(".navbar-nav li a").on("click", function () {
      $(".animated-icon2").click();
    });
  </script>

  <!-- Credit to this article in showing me how to implement the dark mode feature https://www.developerdrive.com/css-dark-mode/ -->
  <script>
    $(".inner-switch").on("click", function () {
      if ($("html").hasClass("dark")) {
        $("html").removeClass("dark");
        $(".inner-switch").text("Sáng");
      } else {
        $("html").addClass("dark");
        $(".inner-switch").text("Tối");
        var head = document.getElementsByTagName("HEAD")[0];
        var link = document.createElement("link");
        link.rel = "stylesheet";
        link.type = "text/css";
        link.href = "/assets/css/dark.css";
        head.appendChild(link);
      }
    });
  </script>

  <script>
    function index() {
      window.location.href = "/index.php";
    }
  </script>
</body>

</html>
