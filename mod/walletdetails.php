<?php
require_once("admin/config.php");
require_once("admin/inc_dbfunctions.php");

$mycon = databaseConnect();
$mycon = databaseConnect();
$dataRead = New DataRead();

$currentuserid = getCookie("userid");

$donationdetails = $dataRead->donation_getbyid($mycon,$currentuserid);

$donationdetail = $dataRead->donations_getbyid($mycon,$currentuserid);

$memberdetails = $dataRead->member_getbyid($mycon, $currentuserid);

//get the last Ph request fulfilled

//get the referral donations bonus
$referraldonationdetails = $dataRead->referraldonations_getbyid($mycon,$currentuserid);


?>

<div class="portlet-body" id="wallet_refresh">
                                             <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Fullname</th>
                                    <th>Initial Amount</th>
                                    <th>Growth</th>
                                    <th>Current Amount</th>
                                    <th>Expected Amount</th>
                                    <th>Status</th>
                                </tr>
                                </thead>


                                <tbody>
                                    <?php
                                    $count = 0;
                                    $totalamount = 0;
                                    foreach($referraldonationdetails as $row)
                                    {
                                        $totalamount += ($row['donation_ph'] * 0.1);
                                    ?>
                                <tr>
                                    <td><?php echo ++$count ?></td>
                                    <td><?php echo formatDate($row['donationcreatedon'], "yes") ?></td>
                                    <td><?php echo 'Referral bonus' ?></td>
                                    <td><?php echo $row['firstname']." ".$row['lastname'] ?></td>
                                    <td><?php echo $row['donation_ph'] ?></td>
                                    <td><?php echo '10%' ?></td>
                                    <td><?php echo ($row['donation_ph'] * 0.1) ?></td>
                                    <td><?php echo ($row['donation_ph'] * 0.1) ?></td>
                                    <td><?php if($row['status'] == '5') echo 'Pending'; else if ($row['status'] == '3') echo 'Matched'; elseif ($row['status'] == '0') echo 'Confirmed'; ?></td>  
                                </tr>
                                <?php
                                }
                                ?>

                                <?php
                                foreach($donationdetails as $row)
                                    { 
                                        if ($row['donation_ph'] != '')
                                        {
                                        $totalamount += ($row['donation_ph'] * 0.1);
                                    ?>
                                <tr>
                                    <td><?php echo ++$count ?></td>
                                    <td><?php echo formatDate($row['donationcreatedon'], "yes") ?></td>
                                    <td><?php echo 'Transfer Fund Request' ?></td>
                                    <td><?php echo $row['firstname']." ".$row['lastname'] ?></td>
                                    <td><?php echo $row['donation_ph'] ?></td>
                                    <td><?php echo '50%' ?></td>
                                    <td><?php echo $row['growth'] ?></td>
                                    <td><?php echo ($row['donation_ph'] + ($row['donation_ph'] * 0.5)) ?></td>
                                    <td><?php if($row['status'] == '5') echo 'Pending'; else if ($row['status'] == '3') echo 'Matched'; elseif ($row['status'] == '0') echo 'Confirmed'; ?></td>  
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                                        </div>

        <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatables/dataTables.bootstrap.js"></script>


        <!-- Modal-Effect -->
        <script src="assets/plugins/custombox/js/custombox.min.js"></script>
        <script src="assets/plugins/custombox/js/legacy.min.js"></script>

        <script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({keys: true});
        $('#datatable-responsive').DataTable();
        $('#datatable-colvid').DataTable({
            "dom": 'C<"clear">lfrtip',
            "colVis": {
                "buttonText": "Change columns"
            }
        });
    });

</script>