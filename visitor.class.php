<?php
class VisitorCounter
{
    var $sessionTimeInMin = 60; // time session will live, in minutes
   
  public  function VisitorCounter()
    {
        if($_SERVER['HTTP_X_FORWARDED_FOR']){
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
		$ip = $_SERVER['REMOTE_ADDR'];
		}
        
		$this->cleanVisitors();

        if ($this->visitorExists($ip))
        {
            $this->updateVisitor($ip);
        } else
        {
            $this->addVisitor($ip);
        }


    }

   public function visitorExists($ip)
    {
        $sql = "select * from counter where ip = '$ip'";
        $res = mysql_query($sql);
        if (mysql_num_rows($res) > 0)
        {
            return true;
        } else
            if (mysql_num_rows($res) == 0)
            {
                return false;
            }
    }

  private  function cleanVisitors()
    {
        $sessionTime = 30;
        $sql = "select * from counter";
        $res = mysql_query($sql);
        while ($row = mysql_fetch_array($res))
        {
            if (time() - $row['lastvisit'] >= $this->sessionTimeInMin * 60)
            {
                $dsql = "delete from counter where id = $row[id]";
                mysql_query($dsql);
            }
        }
    }


  private  function updateVisitor($ip)
    {

        @mysql_query("INSERT INTO iplog (ip) values ('$ip')");
		$sql = "update counter set lastvisit = '" . time() . "' where ip = '$ip'";
        mysql_query($sql);
    }


  private  function addVisitor($ip)
    {
        @mysql_query("INSERT INTO iplog (ip) values ('$ip')");
		$sql = "insert into counter (ip ,lastvisit) value('$ip', '" . time() . "')";
        mysql_query($sql);
    }

  public  function getAmountVisitors()
    {

        $sql = "select count(id) from counter";
        $res = mysql_query($sql);
        $row = mysql_fetch_row($res);
        return $row[0];
    }


   public function show()
    {

        echo '<div style="padding:5px; margin:auto; background-color:#B4CDE2"><b><a style="color:#000000; text-decoration:none;" href="members.php">' .
            $this->getAmountVisitors() . ' Independent Contractors Online</a> | <a style="color:#000000; text-decoration:none;" href="tos.php">Terms of Service</a> | <a style="color:#000000; text-decoration:none;" href="privacy.php">Privacy Policy</a></b></div>';

    }

}
?>