<?php
class  Post
{
	public function pcreate($gid,$object,$post,$subject,$date)
	{
		$query="select max(id) as max from posts";
		$result=mysql_query($query);
		$arr=mysql_fetch_array($result);
		$id=$arr["max"]+1;
		$query="INSERT INTO posts VALUES($id,$gid,$object,'$subject','$post','$date')";
		$result=mysql_query($query);

			}
	public function posts_by_group($gid)
	{
		$query="select * from posts where gid=$gid";
		$result=mysql_query($query);
		$retarray=array();
		while($row=mysql_fetch_array($result))
		{
			$retarray[]=$row;
		}
		return $retarray;
	}

	public function find($object)
	{
		$query="select imguri from MIMGT i where i.imgid =$object";
		$result=mysql_query($query);
		return $result;
	}

	public function update($id,$object,$post,$subject,$date)
	{
		$query="update posts set object=$object,post='$post',subject='$subject',date='$date' where id=$id";
		$result=mysql_query($query);
		
	}

	public function delete($id)
	{
		$query="delete from posts where id=$id ";
		$result=mysql_query($query);	
	}

}
?>
