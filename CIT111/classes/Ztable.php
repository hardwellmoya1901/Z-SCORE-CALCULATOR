<?php
require_once "connectNow.php";



class Ztable{
    //inputs
    private $zscore;
    private $x; //raw score
    private $mean;
    private $sd; //standard deviation

    //setting the attributes
    public function setAttributes(){
        $this->x = $_POST["testValue"];
        $this->mean = $_POST["mean"];
        $this->sd = $_POST["sd"];
    }

    
    
    public function CalculateZscore(){
        $this->setAttributes();

        // error trap (Inputs must be numeric)
        if(is_numeric($this->x) && is_numeric($this->mean) && is_numeric($this->sd)){

                //formula for getting the zscore
                $this->zscore = ($this->x - $this->mean)/$this->sd;
                $this->zscore = number_format($this->zscore,2);

                echo "<script>document.getElementById('zscore').innerHTML = 'Z-Score : ' + ".$this->zscore.".toFixed(2);</script> ";

                
                // error trap (if z-score is found in the reference table)
                if($this->zscore < -3.99 || $this->zscore > 3.99 ){
                    //display error trap
                    echo  "<script> document.getElementById('error1').style.display = 'block';</script>";
                    echo  "<script> document.getElementById('error1').innerHTML = 'Sorry, it seems that the z-score is not on our reference table.';</script>";
                }else{
                    // use the database for negative zscore
                    if($this->zscore < 0 && $this->zscore != 0){
                        $this->NZvalue();
                    // use the database for positive zscore
                    }else{
                        $this->PZvalue();
                    }

                    //display the inputs on the steps section
                    echo "<script>document.getElementById('tbup').innerHTML = ".$this->x." + ' - ' + ".$this->mean."</script> ";
                    echo "<script>document.getElementById('tbdown').innerHTML = ".$this->sd."</script> ";
                    echo "<script>document.getElementById('tbzscore').innerHTML = ".$this->zscore."</script> ";
                }

        }else{
            //display error trap
            echo  "<script> document.getElementById('error1').style.display = 'block';</script>";
             echo  "<script> document.getElementById('error1').innerHTML = 'Input is not a number. Please try again';</script>";
       
        }
        

       


       

        
    }  


    // table for positive z-score
    public function PZvalue(){
        //connect to the database
        $stmt = (new ConnectNow)->connect()->prepare("SELECT zvalue FROM ztablep WHERE zscore = :zscore");
        $stmt -> bindParam(":zscore", $this->zscore, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();

                //Outputs
                //Z Value
                echo "<script>document.getElementById('zvalue').innerHTML = 'P-Value : ' + ".$result["zvalue"].";</script>";
                
                // Z Value(Probabiliyt of x < Raw Score)
                echo "<script>document.getElementById('pl').innerHTML = 'Probability of x < ' + ".$this->x." + ' : ' + ".$result["zvalue"].";</script>";
                // Z Value(Probabiliyt of x > Raw Score)
                echo "<script>document.getElementById('pg').innerHTML = 'Probability of x > ' + ".$this->x." + ' : ' + (1-".$result["zvalue"].").toFixed(5);</script>";
                // Z Value(Probability of x between Raw score and)
                echo "<script>document.getElementById('pb').innerHTML = 'Probability of ' +  ".$this->mean." + ' < x < ' + ".$this->x." + ' : ' + (".$result["zvalue"]."- 0.5).toFixed(5);</script>";

                //steps
                echo "<script>document.getElementById('lz').innerHTML = 'P(x < ' + ".$this->x."+ ') = ' + ".$result["zvalue"].";</script>";
                echo "<script>document.getElementById('gz').innerHTML = 'P(x > ' + ".$this->x."+ ') = 1 - P(x < ' + ".$this->x." + ') = ' + (1-".$result["zvalue"].").toFixed(5);</script>";
                echo "<script>document.getElementById('bz').innerHTML = 'P(' + ".$this->mean." + '< x <' + ".$this->x." + ') = P(x < ' + ".$this->x." + ') - 0.5 = ' + (".$result["zvalue"]."- 0.5).toFixed(5);</script>";
                
                $stmt = null;   
    }

    //table for negative z-score
    public function NZvalue(){
        //connect to the database
        $stmt = (new ConnectNow)->connect()->prepare("SELECT zvalue FROM ztablen WHERE zscore = :zscore");
        $stmt -> bindParam(":zscore", $this->zscore, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();


                //Outputs
                //Z Value
                echo "<script>document.getElementById('zvalue').innerHTML = 'P-Value : ' + ".$result["zvalue"].";</script>";
                
                // Z Value(Probabiliyt of x < Raw Score)
                echo "<script>document.getElementById('pl').innerHTML = 'Probability of x < ' + ".$this->x." + ' : ' + ".$result["zvalue"].";</script>";
                // Z Value(Probabiliyt of x > Raw Score)
                echo "<script>document.getElementById('pg').innerHTML = 'Probability of x >' + ".$this->x." + ' : ' + (1-".$result["zvalue"].").toFixed(5);</script>";
                // Z Value(Probability of x between Raw score and)
                echo "<script>document.getElementById('pb').innerHTML = 'Probability of ' +  ".$this->mean." + ' < x < ' + ".$this->x." + ' : ' + (0.5 - ".$result["zvalue"].").toFixed(5);</script>";

                //steps
                echo "<script>document.getElementById('lz').innerHTML = 'P(x < ' + ".$this->x."+ ') = ' + ".$result["zvalue"].";</script>";
                echo "<script>document.getElementById('gz').innerHTML = 'P(x > ' + ".$this->x."+ ') = 1 - P(x < ' + ".$this->x." + ') = ' + (1-".$result["zvalue"].").toFixed(5);</script>";
                echo "<script>document.getElementById('bz').innerHTML = 'P(' + ".$this->x." + '< x <' + ".$this->mean." + ') = 0.5 - P(x < ' + ".$this->x." + ') = ' + (0.5 - ".$result["zvalue"].").toFixed(5);</script>";
                
                $stmt = null;   
    }


   // Calculate Proportion between two Raw scores

    // Inputs
    private $fzscore;
    private $szscore;
    //Used an array for calculating the P-value between the two raw scores.
    private $zvaluearray = array();
    private $rawarray = array();
    private $bzvalue;


    //setting the attributes
    public function setAttributesBetween(){
        $this->fx = $_POST["ftestValue"];
        $this->sx = $_POST["stestValue"];
        $this->bmean = $_POST["bmean"];
        $this->bsd = $_POST["bsd"];
        //Used an array for displaying the inputs from lowest to highest
        array_push($this->rawarray, $this->fx, $this->sx);
        sort($this->rawarray);

    }

    public function CalculateBetween (){


        $this->setAttributesBetween();

        // error trap (Inputs must be numeric)
        if(is_numeric($this->fx) && is_numeric($this->sx) && is_numeric($this->bmean) && is_numeric($this->bsd)){
            //formula for getting the zscore
            $this->fzscore = ($this->fx - $this->bmean)/$this->bsd;
            $this->fzscore = number_format($this->fzscore,2);
            $this->szscore = ($this->sx - $this->bmean)/$this->bsd;
            $this->szscore = number_format($this->szscore,2);


            echo "<script>document.getElementById('fzscore').innerHTML = 'First Z-Score : ' + ".$this->fzscore.".toFixed(2);</script> ";
            echo "<script>document.getElementById('szscore').innerHTML = 'Second Z-Score : ' + ".$this->szscore.".toFixed(2);</script> ";
    
            // error trap (if z-score is found in the reference table)
            if($this->fzscore < -3.99 || $this->fzscore > 3.99 || $this->szscore < -3.99 || $this->szscore > 3.99){
                //display error trap
                echo  "<script> document.getElementById('error2').style.display = 'block';</script>";
                echo  "<script> document.getElementById('error2').innerHTML = 'Sorry, it seems one of  the z-score is not on our reference table.';</script>";
            }else{
                 
                //display the inputs on the steps section
                echo "<script>document.getElementById('ftbup').innerHTML = ".$this->fx." + ' - ' + ".$this->bmean."</script> ";
                echo "<script>document.getElementById('ftbdown').innerHTML = ".$this->bsd."</script> ";
                echo "<script>document.getElementById('ftbzscore').innerHTML = ".$this->fzscore."</script> ";
                echo "<script>document.getElementById('stbup').innerHTML = ".$this->sx." + ' - ' + ".$this->bmean."</script> ";
                echo "<script>document.getElementById('stbdown').innerHTML = ".$this->bsd."</script> ";
                echo "<script>document.getElementById('stbzscore').innerHTML = ".$this->szscore."</script> ";
    
                
                // use the database for negative zscore
                if($this->fzscore < 0 && $this->fzscore != 0){
                    $this->BNZvalue($this->fzscore,"fzvalue","fpl","fpg",$this->fx,"flz");
                }else{
                     // use the database for positive zscore
                    $this->BPZvalue($this->fzscore,"fzvalue","fpl","fpg",$this->fx,"flz");
                }
                
                // use the database for negative zscore
                if($this->szscore < 0 && $this->szscore != 0){
                    $this->BNZvalue($this->szscore,"szvalue","spl","spg",$this->sx,"slz");
                }else{
                     // use the database for positive zscore
                    $this->BPZvalue($this->szscore,"szvalue","spl","spg",$this->sx,"slz");
                }

                // Sorting the P-value from lowest to highest. This will prevent a negative outcome.
                rsort($this->zvaluearray);
        
                // formula for the proportion between the two raw scores
                $this->bzvalue = ($this->zvaluearray[0] - $this->zvaluearray[1]);
                
                //display the inputs on the steps section
                echo "<script>document.getElementById('bpb').innerHTML = 'Probability of ' +  ".$this->rawarray[0]." + ' < x < ' + ".$this->rawarray[1]." + ' : ' + (".$this->zvaluearray[0] - $this->zvaluearray[1].").toFixed(5);</script>";
                echo "<script>document.getElementById('tdbz').innerHTML = 'Probability of between ' + ".$this->rawarray[0]."+ ' and ' + ".$this->rawarray[1]." ;</script>";
                echo "<script>document.getElementById('dbz').innerHTML = 'P(' + ".$this->rawarray[0]." + '< x <' + ".$this->rawarray[1]." + ') = P(x < ' + ".$this->rawarray[1]." + ') - ' + 'P(x < ' + ".$this->rawarray[0]." + ') = ' + ".$this->bzvalue.";</script>";
    
            }

        }else{
            //display error trap
            echo  "<script> document.getElementById('error2').style.display = 'block';</script>";
            echo  "<script> document.getElementById('error2').innerHTML = 'Input is not a number. Please try again';</script>";
        }

      


        

       


        




    }



    public function BPZvalue($zscore,$zvalue,$pl,$pg,$x,$lz){
        //connect to the database
        $stmt = (new ConnectNow)->connect()->prepare("SELECT zvalue FROM ztablep WHERE zscore = :zscore");
        $stmt -> bindParam(":zscore", $zscore, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();

                //Z Value
                echo "<script>document.getElementById('".$zvalue."').innerHTML = 'P-Value : ' + ".$result["zvalue"].";</script>";
                
                // Z Value(Probabiliyt of x < Raw Score)
                echo "<script>document.getElementById('".$pl."').innerHTML = 'Probability of x < ' + ".$x." + ' : ' + ".$result["zvalue"].";</script>";
                // Z Value(Probabiliyt of x > Raw Score)
                echo "<script>document.getElementById('".$pg."').innerHTML = 'Probability of x > ' + ".$x." + ' : ' + (1-".$result["zvalue"].").toFixed(5);</script>";

                //steps
                echo "<script>document.getElementById('".$lz."').innerHTML = 'P(x < ' + ".$x."+ ') = ' + ".$result["zvalue"].";</script>";

                //Insert the output in the array
                array_push($this->zvaluearray,$result["zvalue"]);
             
                $stmt = null;   
    }

    public function BNZvalue($zscore,$zvalue,$pl,$pg,$x,$lz){
        //connect to the database
        $stmt = (new ConnectNow)->connect()->prepare("SELECT zvalue FROM ztablen WHERE zscore = :zscore");
        $stmt -> bindParam(":zscore", $zscore, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();

                //Z Value
                echo "<script>document.getElementById('".$zvalue."').innerHTML = 'P-Value : ' + ".$result["zvalue"].";</script>";
                
                // Z Value(Probabiliyt of x < Raw Score)
                echo "<script>document.getElementById('".$pl."').innerHTML = 'Probability of x < ' + ".$x." + ' : ' + ".$result["zvalue"].";</script>";
                // Z Value(Probabiliyt of x > Raw Score)
                echo "<script>document.getElementById('".$pg."').innerHTML = 'Probability of x > ' + ".$x." + ' : ' + (1-".$result["zvalue"].").toFixed(5);</script>";
                echo "<script>document.getElementById('".$lz."').innerHTML = 'P(x < ' + ".$x."+ ') = ' + ".$result["zvalue"].";</script>";

                //Insert the output in the array
                array_push($this->zvaluearray,$result["zvalue"]);          
                $stmt = null;   
    }
}

?>

