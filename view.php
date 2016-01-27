<html>
<head>
<title>Video Upload System</title>
<link href="//example.com/path/to/video-js.min.css" rel="stylesheet">
<script src="//example.com/path/to/video.min.js"></script>
<script>
  videojs.options.flash.swf = "http://example.com/path/to/video-js.swf"
</script>
</head>
<body>
<?php 
$con = mysqli_connect("localhost", "root", "", "safePunjab") or die("Connection was not established");
?>
<?php
    $video = $_GET['video'];
?>
<video id="example_video_1" class="video-js vjs-default-skin"
  controls preload="auto" width="640" height="264"
  poster="http://video-js.zencoder.com/oceans-clip.png"
  data-setup='{"example_option":true}'>
<source src="videos_upload/<?php echo $video; ?>" type='video/mp4' />
<source src="http://video-js.zencoder.com/oceans-clip.webm" type='video/webm' />
<source src="http://video-js.zencoder.com/oceans-clip.ogv" type='video/ogg' />

</video>
</body>
</html>