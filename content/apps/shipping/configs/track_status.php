<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 快递公司code => 快递100快递公司名称
 */

return array(
	'yuantong' 	        	=> __('圆通速递', 'shipping'),
    'zhongtong'          	=> __('中通速递', 'shipping'),
    'yunda'               	=> __('韵达快运', 'shipping'),
    'shunfeng'          	=> __('顺丰速运', 'shipping'),
    'shentong'              => __('申通快递', 'shipping'),
	'ems'					=> __('国内邮政特快专递', 'shipping'),
);

// end
/*
 * 快递100快递方式
分类 	快递公司代码 	公司名称
A
    auspost	澳大利亚邮政(英文结果）
    aae	AAE
    anxindakuaixi	安信达
B
    huitongkuaidi	百世汇通
    baifudongfang	百福东方
    bht	BHT
    youzhengguonei	包裹/平邮/挂号信（暂只支持HtmlAPI,要JSON、XML格式结果和签收状态state请转用【企业版】，详情请到http://www.kuaidi100.com/openapi/applypoll.shtml 提交，提交后5分钟给您邮件回复，邮件里有详细的说明与指引。也可以联系企业QQ 800036857转“小佰”咨询）
    bangsongwuliu	邦送物流
C
    cces	希伊艾斯（CCES）
    coe	中国东方（COE）
    chuanxiwuliu	传喜物流
    canpost	加拿大邮政Canada Post（英文结果）
    canpostfr	加拿大邮政Canada Post(德文结果）
D
    datianwuliu	大田物流
    debangwuliu	德邦物流
    dpex	DPEX
    dhl	DHL-中国件-中文结果
    dhlen	DHL-国际件-英文结果
    dhlde	DHL-德国件-德文结果（德国国内派、收的件）
    dsukuaidi	D速快递
    disifang	递四方
E
    ems	EMS(中文结果)
    ems	E邮宝
    emsen	EMS（英文结果）
    emsguoji	EMS-（中国-国际）件-中文结果/EMS-(China-International）-Chinese data
    emsinten	EMS-（中国-国际）件-英文结果/EMS-(China-International）-Englilsh data
F
    fedex	Fedex-国际件-英文结果（说明：Fedex是国际件的英文结果，Fedex中国的请用“lianbangkuaidi”，Fedex-美国请用fedexus）
    fedexcn	Fedex-国际件-中文结果
    fedexus	Fedex-美国件-英文结果(说明：如果无效，请偿试使用fedex）
    feikangda	飞康达物流
    feikuaida	飞快达
    rufengda	凡客如风达
    fengxingtianxia	风行天下
    feibaokuaidi	飞豹快递
G
    ganzhongnengda	港中能达
    guotongkuaidi	国通快递
    guangdongyouzhengwuliu	广东邮政
    youzhengguonei	挂号信 （暂只支持HtmlAPI,要JSON、XML格式结果和签收状态state请转用【企业版】，详情请到http://www.kuaidi100.com/openapi/applypoll.shtml 提交，提交后5分钟给您邮件回复，邮件里有详细的说明与指引。也可以联系企业QQ 800036857转“小佰”咨询）
    youzhengguonei	国内邮件 （暂只支持HtmlAPI,要JSON、XML格式结果和签收状态state请转用【企业版】，详情请到http://www.kuaidi100.com/openapi/applypoll.shtml 提交，提交后5分钟给您邮件回复，邮件里有详细的说明与指引。也可以联系企业QQ 800036857转“小佰”咨询）
    youzhengguoji	国际邮件（暂只支持HtmlAPI,要JSON、XML格式结果和签收状态state请转用【企业版】，详情请到http://www.kuaidi100.com/openapi/applypoll.shtml 提交，提交后5分钟给您邮件回复，邮件里有详细的说明与指引。也可以联系企业QQ 800036857转“小佰”咨询）
    gls	GLS
    gongsuda	共速达
H
    huitongkuaidi	汇通快运
    huiqiangkuaidi	汇强快递
    tiandihuayu	华宇物流
    hengluwuliu	恒路物流
    huaxialongwuliu	华夏龙
    tiantian	海航天天
    haiwaihuanqiu	海外环球
    hebeijianhua	河北建华（暂只能查好乐买的单，其他商家要查，请发邮件至 wensheng_chen#kingdee.com(将#替换成@)开通权限
    haimengsudi	海盟速递
    huaqikuaiyun	华企快运
    haihongwangsong	山东海红
J
    jiajiwuliu	佳吉物流
    jiayiwuliu	佳怡物流
    jiayunmeiwuliu	加运美
    jinguangsudikuaijian	京广速递
    jixianda	急先达
    jinyuekuaidi	晋越快递
    jietekuaidi	捷特快递
    jindawuliu	金大物流
    jialidatong	嘉里大通
K
    kuaijiesudi	快捷速递
    kangliwuliu	康力物流
    kuayue	跨越物流
L
    lianhaowuliu	联昊通
    longbanwuliu	龙邦物流
    lanbiaokuaidi	蓝镖快递
    lejiedi	乐捷递（暂只能查好乐买的单，其他商家要查，请发邮件至 wensheng_chen#kingdee.com(将#替换成@)开通权限
    lianbangkuaidi	联邦快递（Fedex-中国-中文结果）（说明：国外的请用 fedex）
    lianbangkuaidien	联邦快递(Fedex-中国-英文结果）
    lijisong	立即送（暂只能查好乐买的单，其他商家要查，请发邮件至 wensheng_chen#kingdee.com(将#替换成@)开通权限)
    longlangkuaidi	隆浪快递
M
    menduimen	门对门
    meiguokuaidi	美国快递
    mingliangwuliu	明亮物流
O
    ocs	OCS
    ontrac	onTrac
Q
    quanchenkuaidi	全晨快递
    quanjitong	全际通
    quanritongkuaidi	全日通
    quanyikuaidi	全一快递
    quanfengkuaidi	全峰快递
    sevendays	七天连锁
R
    rufengda	如风达快递
S
    shentong	申通（暂只支持HtmlAPI,要JSON、XML格式结果和签收状态state请转用【企业版】，详情请到http://www.kuaidi100.com/openapi/applypoll.shtml 提交，提交后5分钟给您邮件回复，邮件里有详细的说明与指引。也可以联系企业QQ 800036857转“小佰”咨询）
    shunfeng	顺丰（暂只支持HtmlAPI,要JSON、XML格式结果和签收状态state请转用【企业版】，详情请到http://www.kuaidi100.com/openapi/applypoll.shtml 提交，提交后5分钟给您邮件回复，邮件里有详细的说明与指引。也可以联系企业QQ 800036857转“小佰”咨询）
    shunfengen	顺丰（英文结果）（暂只支持HtmlAPI,要JSON、XML格式结果和签收状态state请转用【企业版】，详情请到http://www.kuaidi100.com/openapi/applypoll.shtml 提交，提交后5分钟给您邮件回复，邮件里有详细的说明与指引。也可以联系企业QQ 800036857转“小佰”咨询）
    santaisudi	三态速递
    shenghuiwuliu	盛辉物流
    suer	速尔物流
    shengfengwuliu	盛丰物流
    shangda	上大物流
    santaisudi	三态速递
    haihongwangsong	山东海红
    saiaodi	赛澳递
    haihongwangsong	山东海红（暂只能查好乐买的单，其他商家要查，请发邮件至 wensheng_chen#kingdee.com(将#替换成@)开通权限）
    sxhongmajia	山西红马甲（暂只能查天天网的单，其他商家要查，请发邮件至 wensheng_chen#kingdee.com(将#替换成@)开通权限)
    shenganwuliu	圣安物流
    suijiawuliu	穗佳物流
T
    tiandihuayu	天地华宇
    tiantian	天天快递
    tnt	TNT（中文结果）
    tnten	TNT（英文结果）
	tonghetianxia	通和天下（暂只能查好乐买的单，其他商家要查，请发邮件至 wensheng_chen#kingdee.com(将#替换成@)开通权限）
U
	ups	UPS（中文结果）
	upsen	UPS（英文结果）
	youshuwuliu	优速物流
	usps	USPS（中英文）
W
	wanjiawuliu	万家物流
	wanxiangwuliu	万象物流
	weitepai	微特派（暂只能查天天网的单，其他商家要查，请发邮件至 wensheng_chen#kingdee.com(将#替换成@)开通权限)
X
	xinbangwuliu	新邦物流
	xinfengwuliu	信丰物流
	xingchengjibian	星晨急便（暂不支持，该公司已不存在）
	xinhongyukuaidi	鑫飞鸿（暂不支持，该公司已不存在）
	cces	希伊艾斯(CCES)（暂不支持，该公司已不存在）
	xinbangwuliu	新邦物流
	neweggozzo	新蛋奥硕物流
	hkpost	香港邮政
Y
	yuantong	圆通速递（暂只支持HtmlAPI,要JSON、XML格式结果和签收状态state请转用【企业版】，详情请到http://www.kuaidi100.com/openapi/applypoll.shtml 提交，提交后5分钟给您邮件回复，邮件里有详细的说明与指引。也可以联系企业QQ 800036857转“小佰”咨询）
	yunda	韵达快运（暂只支持HtmlAPI,要JSON、XML格式结果和签收状态state请转用【企业版】，详情请到http://www.kuaidi100.com/openapi/applypoll.shtml 提交，提交后5分钟给您邮件回复，邮件里有详细的说明与指引。也可以联系企业QQ 800036857转“小佰”咨询）
	yuntongkuaidi	运通快递
	youzhengguonei	邮政小包（国内），邮政包裹（国内）、邮政国内给据（国内）（暂只支持HtmlAPI,要JSON、XML格式结果和签收状态state请转用【企业版】，详情请到http://www.kuaidi100.com/openapi/applypoll.shtml 提交，提交后5分钟给您邮件回复，邮件里有详细的说明与指引。也可以联系企业QQ 800036857转“小佰”咨询）
	youzhengguoji	邮政小包（国际），邮政包裹（国际）、邮政国内给据（国际）（暂只支持HtmlAPI,要JSON、XML格式结果和签收状态state请转用【企业版】，详情请到http://www.kuaidi100.com/openapi/applypoll.shtml 提交，提交后5分钟给您邮件回复，邮件里有详细的说明与指引。也可以联系企业QQ 800036857转“小佰”咨询）
	yuanchengwuliu	远成物流
	yafengsudi	亚风速递
	yibangwuliu	一邦速递
	youshuwuliu	优速物流
	yuanweifeng	源伟丰快递
	yuanzhijiecheng	元智捷诚
	yuefengwuliu	越丰物流
	yuananda	源安达
	yuanfeihangwuliu	原飞航
	zhongxinda	忠信达快递
	zhimakaimen	芝麻开门
	yinjiesudi	银捷速递
	yitongfeihong	一统飞鸿（暂只能查天天网的单，其他商家要查，请发邮件至 wensheng_chen#kingdee.com(将#替换成@)开通权限)
Z
	zhongtong	中通速递（暂只支持HtmlAPI,要JSON、XML格式结果和签收状态state请转用【企业版】，详情请到http://www.kuaidi100.com/openapi/applypoll.shtml 提交，提交后5分钟给您邮件回复，邮件里有详细的说明与指引。也可以联系企业QQ 800036857转“小佰”咨询）
	zhaijisong	宅急送
	zhongyouwuliu	中邮物流
	zhongxinda	忠信达
	zhongsukuaidi	中速快件
	zhimakaimen	芝麻开门
	zhengzhoujianhua	郑州建华（暂只能查好乐买的单，其他商家要查，请发邮件至 wensheng_chen#kingdee.com(将#替换成@)开通权限）
	zhongtianwanyun	中天万运
*/