<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Pos Check Report</title>
        <base href="<?=base_url()?>"/>
        <meta http-equiv="cache-control" content="max-age=0"/>
        <meta http-equiv="cache-control" content="no-cache"/>
        <meta http-equiv="expires" content="0"/>
        <meta http-equiv="pragma" content="no-cache"/>
        <link rel="shortcut icon" href="<?=$assets?>images/icon.png"/>
        <link rel="stylesheet" href="<?=$assets?>styles/theme.css" type="text/css"/>
        <style type="text/css" media="all">
            body { color: #000; }
            #wrapper { max-width: 100%; margin: 0 auto; padding-top: 20px; }
            .btn { border-radius: 0; margin-bottom: 5px; }
            h3 { margin: 5px 0; }
            .table th {
                padding: 5px;
            }
            .table td {
                padding: 4px;
            }
        </style>
    </head>

    <body>

<div id="wrapper">
    <div id="receiptData">
    <div id="receipt-data">
        <div class="text-center">
            <!-- <img src="<?=base_url() . 'assets/uploads/logos/' . $biller->logo;?>" alt="<?=$biller->company;?>"> -->
            <h3 style="text-transform:uppercase;"><?=$biller;?></h3>
            <br/>
            <h3 style="text-transform:uppercase;"><?=$title;?></h3>
        </div>    
            <?php 
            	echo "<p>" . lang("Customer_Name") . ": " . $customer . "<br>";
                
            	echo lang("From") . ": " . $fromdate . "<br>";
            	echo lang("To") . ": " . $todate . "</p>";
            ?>
            <div style="clear:both;"></div>
            <table class="table table-striped table-condensed">
                
                <tbody>
                    <tr>
                        <th><?php echo lang('date'); ?></th>
                        <th><?php echo lang('reference_no'); ?></th>
                        <th><?php echo lang('product'); ?></th>
                        <th><?php echo lang('qty'); ?></th>
                        <th><?php echo lang('price'); ?></th>
                        <th><?php echo lang('grand_total'); ?></th>
                        <th><?php echo lang('paid'); ?></th>
                        <th><?php echo lang('balance'); ?></th>
                        <th><?php echo lang('payment_status'); ?></th>
                    </tr>
                <?php
                    $paid = 0;
                    $balance = 0;
                	foreach ($main_data as $data_row) {
                            $paid += $data_row->paid;
                            $balance += ($data_row->grand_total - $data_row->paid);
                            $productname = "";
                            $productArr = explode(",",$data_row->pname);
                            $variantArr = array();
                            if($data_row->oname)
                                $variantArr = explode(",",$data_row->oname);
                            
                            foreach($productArr as $key => $prod) {
                                if(count($variantArr) > 0) {
                                    $productname.=$prod." (".$variantArr[$key].")"."<br/>";
                                } else {
                                    $productname.=$prod."<br/>";
                                }
                            }
                            $qtystr = "";
                            $qtyArr = explode(",",$data_row->qty);
                            foreach($qtyArr as $qarr) {
                                $qtystr .= $this->sma->formatMoney($qarr)."<br/>";
                            }
                            $pricestr = "";
                            $priceArr = explode(",",$data_row->price);
                            foreach($priceArr as $parr) {
                                $pricestr .=$this->sma->formatMoney($parr)."<br/>";
                            }
                ?>
                    <tr>
                        <td><?php echo $this->sma->hrld($data_row->date) ?></td>
                        <td><?php echo $data_row->reference_no ?></td>
                        <td><?php echo $productname ?></td>
                        <td><?php echo $qtystr ?></td>
                        <td><?php echo $pricestr ?></td>
                        <td><?php echo $this->sma->formatMoney($data_row->grand_total) ?></td>
                        <td><?php echo $this->sma->formatMoney($data_row->paid) ?></td>
                        <td><?php echo $this->sma->formatMoney($data_row->grand_total - $data_row->paid) ?></td>
                        <td><?php echo lang($data_row->payment_status) ?></td>
                    </tr>
                <?php
                        }
                ?>
                </tbody>
                
            </table>
            <table class="table table-striped table-condensed">
                <tr>
                    <td colspan="2"><h4>Summary</h4></td>
                </tr>
                <tr>
                    <td><strong>Paid:</strong></td>
                    <td>Ksh <?=$this->sma->formatMoney($paid);?></td>
                </tr>
                <tr>
                    <td><strong>Balance:</strong></td>
                    <td>Ksh <?=$this->sma->formatMoney($balance);?></td>
                </tr>
            </table>    
            
            
        </div>

        
    </div>

</body>
</html>
