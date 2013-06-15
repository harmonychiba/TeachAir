<?php
echo $this->element('HeaderElement');
?>
<table>
    <tr>
        <td width='20%'>
            <div>
                <?php
                echo $this->element('LeftSidebarElement', array('login_user' => $login_user, 'holdings' => $holdings, 'participating_classes', $participating_classes));
                ?>
            </div>
        </td>
        <td width ='60%'>
            <div class="ustream_viewer">
                <?php
                $uid = $video_id;

                $request = 'http://api.ustream.tv';
                $format = 'php';
                $args = ""; // xml | json | html | php
                $args .= 'subject=channel'; // channel | user | video | stream | system
                $args .= '&uid=' . $uid; // subject=channelの場合は、channelのuid
                $args .= '&command=getinfo'; // getinfo getvalueof. getvalueofを使う場合は、$argsにparamsを追記
                $args .= '&key=' . $div_id;

                $session = curl_init($request . '/' . $format . '?' . $args);
                curl_setopt($session, CURLOPT_HEADER, false);
                curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($session);
                curl_close($session);

                $resultsArray = unserialize($response);
                $id = $resultsArray['results']['id'];
                $embedTag = $resultsArray['results']['embedTag'];
                $status = $resultsArray['results']['status']; // live | offline
                $error = $resultsArray['error'];
                if ($error == '') {
                    echo 'status:' . $status;
                    //if ($status == 'offline') {
                    echo '<table><tr><td>' . $embedTag;
                    //echo '<iframe width="800" scrolling="no" height="450" frameborder="0" style="border: 0px none transparent;" src="http://www.ustream.tv/socialstream/' . $id . '"></iframe>';
                    //}
                }
                ?>
            </div>
            <div id='inputs'>
                <table>
                    <tr>
                        <td>
                            <input id="text" type="text" />
                        </td>
                        <td>
                            <input id="get" type="button" value="コメント" />
                        </td>
                    </tr>
                </table>
            </div>
            <div id='comments'></div>
            <script>
                var i = 0;
                function loop() {
                    $.ajax({
                        type: "POST",
                        url: "../comments/class_id:" +<?php echo $class_id; ?>,
                        cache: false,
                        success: function(html) {
                            $("#comments").html(html);
                        }

                    });
                    setTimeout("loop()", 5000);
                }
                loop();

                $(function() {
                    $("#get").click(function() {
                        var value = $("#text").val();
                        $.ajax({
                            type: "POST",
                            url: "../submit/class_id:" +<?php echo $class_id; ?> + "/value:" + value+"/login_id:"+<?php echo $login_id?>,
                            cache: false,
                            success: function(html) {
                                $("#comments").html(html);
                            }
                        });
                        return false;
                    });
                });

            </script>
        </td>
        <td width='20%'>
            <?php
            echo $this->element("RightSidebarElement");
            ?>
        </td>
    </tr>
</table>