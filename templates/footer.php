    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <!-- This is a fallback! If the CDN failed, we fall back to using our local version -->
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>

    <!-- Additional JavaScript -->
    <?php if ( isset( $data[ 'js' ] ) ) echo $data[ 'js' ]; ?>

  </body>
</html>
