<footer class="page-footer" style="margin-top: 120px; box-shadow: 0px 0px 2px white; background-color: rgb(17,17,17)">
  <div class=" wide-container" style="display:flex;flex-wrap:wrap;width:100%;justify-content:space-between;">
    <div class="col s3">
      <h4 class="white-text bold underline">ILLEGAL HUB</h4>
      <p class="grey-text text-lighten-4" style="text-wrap:nowrap;">Your favorite online MarketPlace.</p>
    </div>
    <div class="col s2">
      <h5 class="white-text bold"  style=' text-decoration: underline'>Support</h5>
      <p><a class='dropdown-trigger white-text bold' href='#' data-target='dropdown1'>Customer Care 
        <i class='material-icons' style=' text-decoration: none !important; display: inline-flex; vertical-align: top;'>arrow_drop_down</i>
      </a></p>
      <ul id='dropdown1' class='dropdown-content white'>
        <li><a href='aboutUs.php' class='black-text bold'>About Us</a></li>

        <li class='divider' tabindex='-1'></li>
        <li><a href='contactUs.php' class='black-text bold'>Contact Us</a></li>
      </ul>
    </div>
    <div class="col s2">
      <h5 class="white-text bold">Find Us</h5>
      <p class="bold">
        Monday to Sunday : <br> 24 X 7
      </p>
     
    </div>
    <div class="col s2">
      <h5 class="white-text bold">Social</h5>
      <p class="bold"> Coming Soon!! </p>
    </div>
    <div class="col s3">
      <h5 class="white-text bold ">Verified</h5>

      <div class=imgt>
      <p class="bold"> Verified sellers. Flash, Carded Electronics, CC Fullz </p>
</div>
    </div>
  </div>
  <div class="footer-copyright" style="padding-bottom: 20px;">
    <div class="wide-container underline">© 2024 ILLEGAL HUB Since 2016. All rights reserved.</div>
  </div>

  <script>
    $(document).ready(function() {
      $('.dropdown-trigger').dropdown({
        coverTrigger: false
      });

      $('#pagination').pageMe({
        pagerSelector:'#myPager',
        activeColor: 'blue',
        prevText:'Previous',
        nextText:'Next',
        showPrevNext:true,
        hidePageNumbers:false,
        perPage:5
      });
      
    })
  </script>

</footer>