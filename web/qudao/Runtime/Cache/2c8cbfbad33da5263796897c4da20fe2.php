<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
        <section class="mainwarp">
            <article class="expand_query">
                <header>
                    <h2>今日点击<span style='padding-left: 50px;'><a href="<?php echo WEB_ROOT?>index.php/User/tj_ip" target='_blank' style='color:#2996cc'>ip查询</a></span></h2>
                </header>
                <form action="<?php echo WEB_ROOT?>index.php/User/jiechi" method="GET" style='padding:20px 80px;'>
                    <span>起止日期：&nbsp;&nbsp;</span>
                        <input type="text" style='width:130px;' name="start_date" value="<?php echo ($start_date); ?>">&nbsp;-
                        <input type="text" style='width:130px;' name="end_date" value="<?php echo ($end_date); ?>">
                    <input class="submit" type="submit" value="查询"></br></br>
                </form>     
<span style='padding-left20px;'>时间段：<?php echo ($start_date); ?>&nbsp;&nbsp;--&nbsp;&nbsp;<?php echo ($end_date); ?>&nbsp;&nbsp;&nbsp;&nbsp;下载次数:&nbsp;&nbsp;<?php echo ($xz); ?>&nbsp;&nbsp;&nbsp;&nbsp;注册帐号:&nbsp;&nbsp;<?php echo ($zc); ?>&nbsp;&nbsp;&nbsp;&nbsp;有效用户数量:&nbsp;&nbsp;<?php echo ($yx); ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href='<?php echo WEB_ROOT?>index.php/User/jiechi_user?start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>'>实际用户</a></span>             
                <div id="table_w">
                <table id="num">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>关键词</th>
                            <th>编号</th>
                            <th>点击数</th>
                            <th>下载数</th>
                            <th>注册用户</th>
                            <th>有效用户</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(is_array($rs)): foreach($rs as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["no"]); ?></td>
							<td><?php if($vo["yx_c"] == 0 ): echo ($vo["Info"]); ?>
                                <?php else: ?><span style="color:red"><?php echo ($vo["Info"]); ?></span><?php endif; ?></td>
                            <td><?php echo ($vo["GjcID"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/GjcRecord?GjcID=<?php echo ($vo["GjcID"]); ?>&start_date=<?php echo ($start_date); ?>&end_date=<?php echo ($end_date); ?>" target="_blank"><?php echo ($vo["c"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/GjcDlRecord?GjcID=<?php echo ($vo["GjcID"]); ?>&start_date=<?php echo ($start_date); ?>&end_date=<?php echo ($end_date); ?>" target="_blank"><?php echo ($vo["dl_c"]); ?></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/tj_zc?GjcID=<?php echo ($vo["GjcID"]); ?>&start_date=<?php echo ($start_date); ?>&end_date=<?php echo ($end_date); ?>" target="_blank"><?php echo ($vo["zc_c"]); ?></a></td>
                            <td><a href="<?php echo WEB_ROOT?>index.php/User/tj_yx?GjcID=<?php echo ($vo["GjcID"]); ?>&start_date=<?php echo ($start_date); ?>&end_date=<?php echo ($end_date); ?>" target="_blank"><?php echo ($vo["yx_c"]); ?></a></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                    
                </table>
                </div>
            </article>          

        </section>
    </div>
</div>  
</body>
</html>