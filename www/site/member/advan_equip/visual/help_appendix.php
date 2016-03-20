<?php
/*	****************************************************************
		help/凡例のテーブルを表示
		
		$helpAppendixMode1 = 表示項目
								1:	コンディション
								2:	コネクター
								3:	色
	****************************************************************/


	// mode1=1 コンディション
	if ($helpAppendixMode1 == 1) {
		echo "
<table summary=\"コンディションの凡例\" class=\"condition\">
	<tr>
		<th class=\"cond1\" scope=\"row\">良好</th>
		<td class=\"cond1\">異常なく使用でき、状態も良好な場合。</td>
	</tr>
	<tr>
		<th class=\"cond2\" scope=\"row\">微妙</th>
		<td class=\"cond2\">音や性能などには問題なく使用できるが、それ以外の部分で多少気になる点がある場合。</td>
	</tr>
	<tr>
		<th class=\"cond3\" scope=\"row\">不調</th>
		<td class=\"cond3\">完全に使用できないというわけではないが、音や性能などに異常がある場合。</td>
	</tr>
	<tr>
		<th class=\"cond4\" scope=\"row\">故障</th>
		<td class=\"cond4\">音や性能などに異常があり、完全に使用できない場合。</td>
	</tr>
	<tr>
		<th class=\"cond5\" scope=\"row\">修理</th>
		<td class=\"cond5\">修理に出している、または部内で修理している最中である場合。</td>
	</tr>
	<tr>
		<th class=\"cond6\" scope=\"row\">不明</th>
		<td class=\"cond6\">状態が把握できていない、または以上の状態のいずれにも属さない場合。</td>
	</tr>
	<tr>
		<th class=\"cond0\" scope=\"row\">総数</th>
		<td class=\"cond0\">所持している機材の総数。</td>
	</tr>
</table>";
	}
	
	
	// mode1=2 コンディション
	if ($helpAppendixMode1 == 2) {
		echo "
<table summary=\"コンディションの凡例\" class=\"connector\">
	<tr>
		<th scope=\"row\">C</th>
		<td>XLR。キャノン。特記のないものはXLR3。</td>
	</tr>
	<tr>
		<th scope=\"row\">F</th>
		<td>標準。フォン。特記のないものはTSフォン。(ST)はTRSフォン。</td>
	</tr>
	<tr>
		<th scope=\"row\">P</th>
		<td>RCA。ピン。</td>
	</tr>
	<tr>
		<th scope=\"row\">M</th>
		<td>ミニ。特記のないものはモノラル。(ST)はステレオ。</td>
	</tr>
	<tr>
		<th scope=\"row\">Sp</th>
		<td>スピコン。特記のないものはNL4。</td>
	</tr>
	<tr>
		<th scope=\"row\">バラ</th>
		<td>先バラ。</td>
	</tr>
	<tr>
		<th scope=\"row\">マルチ</th>
		<td>マルチ。特記のないものはFK37。</td>
	</tr>
	<tr>
		<th scope=\"row\">平</th>
		<td>平行。電源。特記のないものはアースなし。(3pin)はアース付き。</td>
	</tr>
	<tr>
		<th scope=\"row\">T</th>
		<td>T型。電源。</td>
	</tr>
	<tr>
		<th scope=\"row\">ワニ</th>
		<td>ワニ口クリップ。</td>
	</tr>
</table>";
	}
	
	
	// mode1=3 色
	if ($helpAppendixMode1 == 3) {
		echo "
<table summary=\"色記号の凡例\" class=\"color\">
	<tr>
		<th scope=\"row\" class=\"black\">Bk</th>
		<td>Black。黒。</td>
		<th scope=\"row\" class=\"brown\">Br</th>
		<td>Brown。茶。</td>
		<th scope=\"row\" class=\"red\">R</th>
		<td>Red。赤。</td>
	</tr>
	<tr>
		<th scope=\"row\" class=\"pink\">Pk</th>
		<td>Pink。桃。</td>
		<th scope=\"row\" class=\"orange\">O</th>
		<td>Orange。橙。</td>
		<th scope=\"row\" class=\"yellow\">Y</th>
		<td>Yellow。黄。</td>
	</tr>
	<tr>
		<th scope=\"row\" class=\"green\">G</th>
		<td>Green。緑。</td>
		<th scope=\"row\" class=\"aqua\">Aq</th>
		<td>Aqua。水色。</td>
		<th scope=\"row\" class=\"blue\">B</th>
		<td>Blue。青。</td>
	</tr>
	<tr>
		<th scope=\"row\" class=\"purple\">P</th>
		<td>Purple。紫。</td>
		<th scope=\"row\" class=\"gray\">Gy</th>
		<td>Gray。灰。</td>
		<th scope=\"row\" class=\"silver\">S</th>
		<td>Silver。銀。</td>
	</tr>
	<tr>
		<th scope=\"row\" class=\"white\">W</th>
		<td>White。白。</td>
	</tr>
</table>";
	}

?>
