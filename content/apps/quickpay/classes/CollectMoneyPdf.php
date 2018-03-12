<?php

namespace Ecjia\App\Quickpay;

class CollectMoneyPdf
{
    protected $store_name;
    
    protected $store_logo;
    
    protected $collectmoney_qrcode;
    
    /**
     * 
     * @param string $store_name
     * @param string $store_logo    url
     * @param string $collectmoney_qrcode   url
     */
    public function __construct($store_name, $store_logo, $collectmoney_qrcode)
    {
        $this->store_name = $store_name;
        $this->store_logo = $store_logo;
        $this->collectmoney_qrcode = $collectmoney_qrcode;
    }
    
    
    /**
     * 生成收款码PDF
     * 
     * @param string $output   
     * Dest：PDF输出的方式。
     *      I，默认值，在浏览器中打开；
     *      D，点击下载按钮， PDF文件会被下载下来；
     *      F，文件会被保存在服务器中；
     *      S，PDF会以字符串形式输出；
     *      E：PDF以邮件的附件输出。
     * @return string
     */
    public function make($output)
    {
        $html = $this->formatTableHtml();
        $this->createPDF($html, $output);
    }
    
    public function createPDF($html, $output = 'I')
    {
        $pdf = royalcms('tcpdf');
        // 设置文档信息
        $pdf->SetCreator('收款二维码');
        $pdf->SetAuthor('ECJia Team');
        $pdf->SetTitle('收款二维码');
        $pdf->SetSubject('收款二维码');
        $pdf->SetKeywords('收款, 二维码, ecjia, 到家');
        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        
        // 设置默认等宽字体
        $pdf->SetDefaultMonospacedFont('courier');
        
        // 设置间距
        $pdf->SetMargins(15, 15, 15);//页面间隔
        $pdf->SetHeaderMargin(5);//页眉top间隔
        $pdf->SetFooterMargin(10);//页脚bottom间隔
        
        
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);
        
        //设置字体 stsongstdlight支持中文
        $pdf->SetFont('stsongstdlight', '', 14);
        
        //第一页
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        
        /* 输入PDF文档 :
        Name：PDF保存的名字
        Dest：PDF输出的方式。I，默认值，在浏览器中打开；D，点击下载按钮， PDF文件会被下载下来；F，文件会被保存在服务器中；S，PDF会以字符串形式输出；E：PDF以邮件的附件输出。 
        */
        $pdf->Output('ecjia_collect_money.pdf', $output);
    }
    
    /**
     * 生成收款码HTML页面
     *
     * @return string
     */
    public function formatTableHtml()
    {
        $collectHtml = $this->formatHtml();
        
        $tablehtml = <<<EOL
        <table>
            <tr>
                <td>
                    {$collectHtml}
                </td>
                <td>
                    {$collectHtml}
                </td>
            </tr>
            <tr>
                <td>
                    {$collectHtml}
                </td>
                <td>
                    {$collectHtml}
                </td>
            </tr>
        </table>
EOL;
        return $tablehtml;
    }
    
    /**
     * 生成收款码HTML页面
     * 
     * @return string
     */
    public function formatHtml()
    {
        $html = <<<EOL
        <div style="border: 2px solid #eee; float: left; background-color: #379ED8; text-align: center;">
            <div><img src="{$this->store_logo}" style="width: 200px;height: 200px;"></div>
            <div style="font-size: 18pt;color: #fff; width: 500px;">{$this->store_name}</div>
            <div style="margin-top: 20px;"><img src="{$this->collectmoney_qrcode}" style="width: 530px;height: 530px;"></div>
            <div style="color: #fff;font-size: 12pt; margin-top: 20px;">微信扫描二维码进行买单</div>
        </div>
EOL;
        return $html;
    }
 
}
