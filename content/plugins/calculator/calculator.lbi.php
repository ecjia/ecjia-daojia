<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="accordion-group">
	<div class="accordion-heading">
		<a href="#collapse101" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
		   <i class="icon-th"></i> {t}计算器{/t}
		</a>
	</div>
	<div class="accordion-body collapse" id="collapse101">
		<div class="accordion-inner">
			<form name="Calc" id="calc">
				<div class="formSep control-group input-append">
					<input type="text" style="width:130px" name="Input" /><button type="button" class="btn" name="clear" value="c" OnClick="Calc.Input.value = ''"><i class="icon-remove"></i></button>
				</div>
				<div class="control-group">
					<input type="button" class="btn btn-large" name="seven" value="7" OnClick="Calc.Input.value += '7'" />
					<input type="button" class="btn btn-large" name="eight" value="8" OnCLick="Calc.Input.value += '8'" />
					<input type="button" class="btn btn-large" name="nine" value="9" OnClick="Calc.Input.value += '9'" />
					<input type="button" class="btn btn-large" name="div" value="/" OnClick="Calc.Input.value += ' / '">
				</div>
				<div class="control-group">
					<input type="button" class="btn btn-large" name="four" value="4" OnClick="Calc.Input.value += '4'" />
					<input type="button" class="btn btn-large" name="five" value="5" OnCLick="Calc.Input.value += '5'" />
					<input type="button" class="btn btn-large" name="six" value="6" OnClick="Calc.Input.value += '6'" />
					<input type="button" class="btn btn-large" name="times" value="x" OnClick="Calc.Input.value += ' * '" />
				</div>
				<div class="control-group">
					<input type="button" class="btn btn-large" name="one" value="1" OnClick="Calc.Input.value += '1'" />
					<input type="button" class="btn btn-large" name="two" value="2" OnCLick="Calc.Input.value += '2'" />
					<input type="button" class="btn btn-large" name="three" value="3" OnClick="Calc.Input.value += '3'" />
					<input type="button" class="btn btn-large" name="minus" value="-" OnClick="Calc.Input.value += ' - '" />
				</div>
				<div class="formSep control-group">
					<input type="button" class="btn btn-large" name="dot" value="." OnClick="Calc.Input.value += '.'" />
					<input type="button" class="btn btn-large" name="zero" value="0" OnClick="Calc.Input.value += '0'" />
					<input type="button" class="btn btn-large" name="DoIt" value="=" OnClick="Calc.Input.value = Math.round( eval(Calc.Input.value) * 1000)/1000" />
					<input type="button" class="btn btn-large" name="plus" value="+" OnClick="Calc.Input.value += ' + '" />
				</div>
			</form>
		</div>
	 </div>
</div>