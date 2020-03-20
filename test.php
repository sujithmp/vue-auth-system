public function switchRelation(){
	

	// decide when do this function is called 

	// called during initial relation saving / drafting

	// this function should be able to give the right option for relation
	//  as well the right relation
	// 
	// so there should be a fixed flexible switching pattern
	// design  the pattern

	// basically this function is called whenever drafted data is to shown one after the another

	// so this to be work there should be atleast one drafted data in the datbase table

	// figure out the different scenarios first

	// user lands  add relation page

	// first of all he can add  a relation and save 




	//  draft

        father relation is drafted so the next relation option is to switched

        each time user drafts a relation it should go to next relation

        here once the father is drafted mother relation comes

        once the mother relation is drafted  wife relation comes
          if exwife is there that one also comes

        next wife father relation comes



        next wife mother relation


        son relation comes if only there is spouse relation should be either drafted or added
        or atleast one exwife is drafted or saved

        may be user adds daughter relation



	// once all the relation is drafted

       now the relation yet to fill will be empty

       but relation mandatory is not empty

       in that case we will check the last saved relation from the database
    //

    /* get the last saved relation*/

    $dtls = Usersdetails::find($this->user_details_id);

    /* check whether user has any drafted details*/

    $drafts = $dtls->user_draft_details()->exists();

    if($drafts) {
    	// 
    	$alldrafts = $dtls->user_draft_details()->rightJoin(function($query){

    		$query->('user_draft_details.id' = 'user_relation_draft.user_to_id');
    	})->where('status','=','drafted')
    	->latest('user_relation_draft.updated_at');

    	// create an array to switch to relations

    	// father

    	$dummy =  ['relation' => '','order'=> '','is_user_parent'=>true];
    	$order = [];
    	$lastupdated = $alldrafts->first()->id;
    	foreach($alldrafts as $key=>$draft) {

    		$order[] = ['relation'=>$draft->relation_type,'order'=> 0,'is_user_parent'=>$draft->is_user_parent,'relation_id'=>$draft->id];
    		if($order[$key]['relation_type'] == 'FATHER' && $draft->is_user_parent== true) {
    			$order[$key]['order'] = 1;
    		} else if($order[$key]['relation_type'] == 'MOTHER' && $draft->is_user_parent== true) {

    			$order[$key]['order'] = 2;
    		} elseif($order[$key]['relation_type'] == 'WIFE') {

    			$order[$key]['order'] = 3;
    		} elseif($order[$key]['relation_type'] == 'HUSBAND'){
    			$order[$key]['order'] = 3;
    		} elseif($order[$key]['relation_type'] == 'EXWIFE'){
    			$order[$key]['order'] = 4;
    		} elseif($order[$key]['relation_type'] == 'EXHUSBAND'){
    			$order[$key]['order'] = 4;
    		} elseif($order[$key]['relation_type'] == 'MOTHER'){
    			$order[$key]['order'] = 6;
    		} elseif($order[$key]['relation_type'] == 'FATHER'){
    			$order[$key]['order'] = 5;
    		} elseif($order[$key]['relation_type'] == 'SON'  && $draft->is_user_parent== true){
    			$order[$key]['order'] = 7;
    		} elseif($order[$key]['relation_type'] == 'DAUGHTER' && $draft->is_user_parent== true){
    			$order[$key]['order'] = 7;
    		} elseif($order[$key]['relation_type'] == 'BROTHER'){
    			$order[$key]['order'] = 8;
    		} elseif($order[$key]['relation_type'] == 'SISTER'){
    			$order[$key]['order'] = 8;
    		} 

    	}
    	
    	$_POST['lastupdated'] = $lastupdated;
    	$lastupdateItem = array_filter($order,function($item,$index){
    		if($item->id == $_POST['lastupdated']) {
    			return true;
    		} else {
    			return false;
    		}
    	},ARRAY_FILTER_BOTH_USE);
    	$excludlastupdateItem = array_filter($order,function($item,$index){
    		if($item->id == $_POST['lastupdated']) {
    			return false;
    		} else {
    			return true;
    		}
    	},ARRAY_FILTER_BOTH_USE);

    	$nextinThesequencekey = array_search($lastupdateItem[0]['order'],array_column($excludelastupdateItem),true);
    	if(!is_bool($nextinThesequencekey)) {

    		
    	} else {

    	}

    } else {
       // this is initial condition 
       // it should start with whatever relation should be mandatory


       // once the mandatory details has been finished

       // and user can draft atleast one relation
       // 

    }
}