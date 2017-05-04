<?php if (!defined('THINK_PATH')) exit(); require_once('head.html'); ?>
		<section class="mainwarp">
			<article class="cx_form">	
				<header>
                    <h2>当日排行</h2>
                </header>		
				<form action="<?php echo WEB_ROOT?>index.php/User/inout_record" metdod="GET">
                    <span style="margin-left:200px;">查询日期&nbsp;&nbsp;</span>
					<input name="date" type="text" class="datepick" value="<?php echo ($date); ?>">
					<input class="submit" type="submit" value="查询">
                </form>
			</article>
			<article class="cx_form">
				<div id="table_w">
				<table id="num">
					<thead>
						<tr>
							<th>时间点</th>
							<th>vip转出</th>
							<th>转入vip</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td><?php echo ($zc['t1']); ?></td>
							<td><?php echo ($zr['t1']); ?></td>
						</tr>
						<tr>
							<td>2</td>
							<td><?php echo ($zc['t2']); ?></td>
							<td><?php echo ($zr['t2']); ?></td>
						</tr>
						<tr>
							<td>3</td>
							<td><?php echo ($zc['t3']); ?></td>
							<td><?php echo ($zr['t3']); ?></td>
						</tr>
						<tr>
							<td>4</td>
							<td><?php echo ($zc['t4']); ?></td>
							<td><?php echo ($zr['t4']); ?></td>
						</tr>
						<tr>
							<td>5</td>
							<td><?php echo ($zc['t5']); ?></td>
							<td><?php echo ($zr['t5']); ?></td>
						</tr>
						<tr>
							<td>6</td>
							<td><?php echo ($zc['t6']); ?></td>
							<td><?php echo ($zr['t6']); ?></td>
						</tr>
						<tr>
							<td>7</td>
							<td><?php echo ($zc['t7']); ?></td>
							<td><?php echo ($zr['t7']); ?></td>
						</tr>
						<tr>
							<td>8</td>
							<td><?php echo ($zc['t8']); ?></td>
							<td><?php echo ($zr['t8']); ?></td>
						</tr>
						<tr>
							<td>9</td>
							<td><?php echo ($zc['t9']); ?></td>
							<td><?php echo ($zr['t9']); ?></td>
						</tr>
						<tr>
							<td>10</td>
							<td><?php echo ($zc['t10']); ?></td>
							<td><?php echo ($zr['t10']); ?></td>
						</tr>
						<tr>
							<td>11</td>
							<td><?php echo ($zc['t11']); ?></td>
							<td><?php echo ($zr['t11']); ?></td>
						</tr>
						<tr>
							<td>12</td>
							<td><?php echo ($zc['t12']); ?></td>
							<td><?php echo ($zr['t12']); ?></td>
						</tr>
						<tr>
							<td>13</td>
							<td><?php echo ($zc['t13']); ?></td>
							<td><?php echo ($zr['t13']); ?></td>
						</tr>
						<tr>
							<td>14</td>
							<td><?php echo ($zc['t14']); ?></td>
							<td><?php echo ($zr['t14']); ?></td>
						</tr>
						<tr>
							<td>15</td>
							<td><?php echo ($zc['t15']); ?></td>
							<td><?php echo ($zr['t15']); ?></td>
						</tr>
						<tr>
							<td>16</td>
							<td><?php echo ($zc['t16']); ?></td>
							<td><?php echo ($zr['t16']); ?></td>
						</tr>
						<tr>
							<td>17</td>
							<td><?php echo ($zc['t17']); ?></td>
							<td><?php echo ($zr['t17']); ?></td>
						</tr>
						<tr>
							<td>18</td>
							<td><?php echo ($zc['t18']); ?></td>
							<td><?php echo ($zr['t18']); ?></td>
						</tr>
						<tr>
							<td>19</td>
							<td><?php echo ($zc['t19']); ?></td>
							<td><?php echo ($zr['t19']); ?></td>
						</tr>
						<tr>
							<td>20</td>
							<td><?php echo ($zc['t20']); ?></td>
							<td><?php echo ($zr['t20']); ?></td>
						</tr>
						<tr>
							<td>21</td>
							<td><?php echo ($zc['t21']); ?></td>
							<td><?php echo ($zr['t21']); ?></td>
						</tr>
						<tr>
							<td>22</td>
							<td><?php echo ($zc['t22']); ?></td>
							<td><?php echo ($zr['t22']); ?></td>
						</tr>
						<tr>
							<td>23</td>
							<td><?php echo ($zc['t23']); ?></td>
							<td><?php echo ($zr['t23']); ?></td>
						</tr>
						<tr>
							<td>24</td>
							<td><?php echo ($zc['t24']); ?></td>
							<td><?php echo ($zr['t24']); ?></td>
						</tr>

						</foreach>
					</tbody>
					
				</table>
				</div>
			</article>			
		</section>
	</div>
</div>	
</body>
</html>