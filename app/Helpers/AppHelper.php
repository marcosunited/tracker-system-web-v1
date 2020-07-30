<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class AppHelper {
    function toDate($timestring) {
        if ($timestring) {
            return date("d-m-Y", $timestring);
        } else {
            return null;
        }
    }
    function liftNames($names,$return=null)
    {
        $ids = rtrim(ltrim($names,"|"),"|");
        $ids = explode("|",$ids);
        $string = "";
		
        $i=0;
        foreach($ids as $id){
            $row = DB::table('lifts')
            ->where('id', '=', $id)
            ->value('lift_name');
            $string .= $row;
            $i++;
            if($i<count($ids))
                $string .= ",";
        }
		if($return == null){
			echo $string;
		}else{
			return $string;
		}		
    }

    function toDay($timestring) {
        if ($timestring) {
            return date("D", $timestring);
        } else {
            return null;
        }
    }

    function toTime($timestring) {
        if ($timestring) {
            return date("H:i", $timestring);
        } else {
            return null;
        }
    }

    function toDateTime($timestring) {
        if ($timestring) {
            return date("d/m/Y H:i:s", $timestring);
        }
    }

    function toDuration($time) {
        if (is_numeric($time)) {
            $value = array(
                "years" => 0, "days" => 0, "hours" => 0,
                "minutes" => 0, "seconds" => 0,
            );
            if ($time >= 31556926) {
                $value["years"] = floor($time / 31556926);
                $time = ($time % 31556926);
            }
            if ($time >= 86400) {
                $value["days"] = floor($time / 86400);
                $time = ($time % 86400);
            }
            if ($time >= 3600) {
                $value["hours"] = floor($time / 3600);
                $time = ($time % 3600);
            }
            if ($time >= 60) {
                $value["minutes"] = floor($time / 60);
                if ($value["minutes"] < 10)
                    $value["minutes"] = "0".$value["minutes"];
                $time = ($time % 60);
            }

            $value["seconds"] = floor($time);
            if ($value["seconds"] < 10)
                $value["seconds"] = "0".$value["seconds"];

            $value["hours"] = $value["hours"] + ($value["days"] * 24);
            return $value["hours"].
            ":".$value["minutes"];
        } else {
            return (bool) FALSE;
        }
    }

    function toDuration2($time) {
        if (is_numeric($time)) {
            $value = array(
                "years" => '', "days" => '', "hours" => 0,
                "minutes" => 0, "seconds" => 0,
            );
            if ($time >= 31556926) {
                $value["years"] = floor($time / 31556926);
                $time = ($time % 31556926);
            }
            if ($time >= 86400) {
                $value["days"] = floor($time / 86400);
                $time = ($time % 86400);
            }
            if ($time >= 3600) {
                $value["hours"] = floor($time / 3600);
                $time = ($time % 3600);
            }
            if ($time >= 60) {
                $value["minutes"] = floor($time / 60);
                if ($value["minutes"] < 10)
                    $value["minutes"] = "0".$value["minutes"];
                $time = ($time % 60);
            }

            $value["seconds"] = floor($time);
            if ($value["seconds"] < 10)
                $value["seconds"] = "0".$value["seconds"];

            //$value["hours"] = $value["hours"] + ($value["days"] * 24);
            return $value["days"].
            " Days, ".$value["hours"].
            " Hours, ".$value["minutes"].
            " Mins";
        } else {
            return (bool) FALSE;
        }

		}
		
		function parentList($inputFieldName,$parentTable,$selectedId,$relation_name,$where){
			$relation_name = explode(",",$relation_name);
			$query = "select * from $parentTable $where ";
			$result = query($query);
			//echo "<input name='$inputFieldName' type='hidden' >";
			echo "<select name=\"$inputFieldName\" id=\"$inputFieldName\">";
			echo "<option value=''>SELECT</option>";
			while($row = mysqli_fetch_array($result)){
				$fieldValueName = str_replace("frm_","",$inputFieldName);
				$selected = "";
				if($row["$fieldValueName"] == $selectedId)
					$selected = "SELECTED";
				$relation_name_o = "";
				foreach($relation_name as $value){
					echo $row["$value"];
					$relation_name_o = $relation_name_o . " " .$row["$value"];
				}
				echo "<option $selected VALUE=\"".$row["$fieldValueName"]."\">".$relation_name_o."</option>";
				$selected = "";
			}
			echo "</select>";
		}
		
		function parentListReq($inputFieldName,$parentTable,$selectedId,$relation_name,$where){
			$relation_name = explode(",",$relation_name);
			$query = "select * from $parentTable $where ";
			$result = DB::select($query);
			//echo "<input name='$inputFieldName' type='hidden' >";
			echo "<select class='form-control' name=\"$inputFieldName\" id=\"$inputFieldName\" class=\"required\">";
			echo "<option value=''>Please Select</option>";
			while($row = mysqli_fetch_array($result)){
				$fieldValueName = str_replace("frm_","",$inputFieldName);
				$selected = "";
				if($row["$fieldValueName"] == $selectedId)
					$selected = "SELECTED";
				$relation_name_o = "";
				foreach($relation_name as $value){
					//echo $row["$value"];
					$relation_name_o = $relation_name_o . " " .$row["$value"];
				}
				echo "<option $selected VALUE=\"".$row["$fieldValueName"]."\">".$relation_name_o."</option>";
				$selected = "";
			}
			echo "</select>";
        }
        
        function list_round_techs($round_id)
        {
            $query = "select * from technicians where round_id = $round_id AND status_id = 1";
            $techs = DB::select($query);
            $tech_name = "";
            foreach($techs as $tech){
               $tech_name = $tech_name.  ' ' . $tech->technician_name; 
            }
            return $tech_name;
        }
        
        //Do a count of all the lift units in a round
        function round_lift_count($round_id)
        {          
            $query="select * from jobs where round_id = $round_id and jobs.status_id = 1";
            $results = DB::select($query);
            $lift_count = 0;
            foreach($results as $result){
                $job_id = $result->id;
                $query = "select count(*) as lift_count from lifts where job_id = $job_id";
                $lifts = DB::select($query);
                foreach($lifts as $lift){
                $lift_count = $lift_count + $lift->lift_count;
            }
            }
            return $lift_count;
        }
        
        //Do a lift count for a Job
        function job_lift_count($job_id)
        {   
            $query="select * from jobs where job_id = $job_id and jobs.status_id=1";
            $result = query($query);
            $lift_count = 0;
            while($row=mysqli_fetch_array($result)){
                $job_id = $row["job_id"];
                $query = "select count(*) as lift_count from lifts where job_id = $job_id";
                $lifts = mysqli_fetch_array(query($query));
                $lift_count = $lift_count + $lifts["lift_count"];
            }
            return $lift_count;
        } 

    function grapher($count,$dataArray) {
        echo "<table border='0' align='center'>";
        $colors = array(1 => 'black', 2 => '#145da1');
        $i=1;
        $x=1;
        foreach($dataArray as $postvar=>$value){
            $percent = round($value/$count*100);
            $height = 20 + $percent;
            
            echo "<td  height='30px' valign='bottom' align='center'>";
            echo "<div style='width:30px;height:{$height}px;background-color:$colors[$i];color:#ffffff;text-align:center;min-height:20px;'>$value</div> $x ";	
            echo "</td>";
            $i++;
            $x++;
            if($i==3)
                $i=1;
        }
        echo "<td width='50px'></td><td>";
        $x=1;
        foreach($dataArray as $postvar=>$value){
            echo "$x = $postvar <br>";
            $x++;
        }
        echo "</td>";
        echo "</tr>";
        echo "</table>";
    }


    public static function instance() {
        return new AppHelper();
    }
}
