<style>
    .log-body {
        border: 1px solid #ccc;
        padding: 15px;
        margin: 10px;
        border-radius: 5px;
        box-shadow: 3px 3px 5px rgb(15 182 237 / 71%);
    transition: box-shadow 0.3s cubic-bezier(0, -1.49, 1, 0.3);
    }

    .log-body:hover {
        box-shadow: 3px 3px 5px rgb(243 9 146 / 84%);
        transition: box-shadow 0.3s cubic-bezier(0, -1.49, 1, 0.3);
    }   
    .custom-menu {
        z-index: 1000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid #0000001c;
        border-radius: 5px;
        padding: 8px;
        min-width: 13vw;
    }
    a.custom-menu-list {
        width: 100%;
        display: flex;
        color: #4c4b4b;
        font-weight: 600;
        font-size: 1em;
        padding: 1px 11px;
    }
    span.card-icon {
        position: absolute;
        font-size: 3em;
        bottom: .2em;
        color: #ffffff80;
    }
    .file-item {
        cursor: pointer;
    }
    a.custom-menu-list:hover, .file-item:hover, .file-item.active {
        background: #80808024;
    }
    table th, td {
        /*border-left:1px solid gray;*/
    }
    a.custom-menu-list span.icon {
        width: 1em;
        margin-right: 5px
    }
</style>

<!-- <div class="container-fluid">
    <div class="pagetitle">
        <h1>Logs</h1>
        </div>
    </div>

    <br>
    <hr> -->
    

    <section class="section dashboard">
            <?php include('db_connect.php');
                $users_query = $conn->query("SELECT * FROM users_logs order by id DESC");
                ?>
                <div class="row mt-3 ml-3 mr-3">
                        <div class="log-body">
                        <table width="100%">
                                <tr>
                                    <th width="20%" class="">Status</th>
                                    <th width="30%" class="">Users</th>
                                    <th width="20%" class="">Dates</th>
                                </tr>
                                <?php
                                $random_colors = array('#d3d3f0', '#e0f8e9', '#ffecdf');
                                $previous_color_index = -1;

                                while ($row = $users_query->fetch_assoc()):
                                    do {
                                        $random_index = array_rand($random_colors);
                                    } while ($random_index === $previous_color_index);

                                    $random_color = $random_colors[$random_index];
                                    $previous_color_index = $random_index;
                                    ?>
                                    <tr class='file-item' style="background-color: <?php echo $random_color; ?>">
                                        <td><large><span><i class="fa fa-info-circle "></i><span><b><?php echo ucwords($row['status']) ?></b></large></td>
                                        <td><i><?php echo $row['users'] ?></td>
                                        <td><i><span> <?php echo date('Y/m/d h:i A',strtotime($row['dates'])) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </table>
                        </div>
                </div>
    </section>
    
</div>
<div id="menu-file-clone" style="display: none;">
    <a href="javascript:void(0)" class="custom-menu-list file-option download"><span><i class="fa fa-download"></i></span> Download</a>
</div>
<script>
    //FILE
    $('.file-item').bind("contextmenu", function (event) {
        event.preventDefault();

        $('.file-item').removeClass('active')
        $(this).addClass('active')
        $("div.custom-menu").hide();
        var custom = $("<div class='custom-menu file'></div>")
        custom.append($('#menu-file-clone').html())
        custom.find('.download').attr('data-id', $(this).attr('data-id'))
        custom.appendTo("body")
        custom.css({top: event.pageY + "px", left: event.pageX + "px"});

        $("div.file.custom-menu .download").click(function (e) {
            e.preventDefault()
            window.open('download.php?id=' + $(this).attr('data-id'))
        })
    })

    $(document).bind("click", function (event) {
        $("div.custom-menu").hide();
        $('.file-item').removeClass('active')
    });

    $(document).keyup(function (e) {
        if (e.keyCode === 27) {
            $("div.custom-menu").hide();
            $('.file-item').removeClass('active')
        }
    })
</script>
