<?php
	class Constants
	{
		public static $dbhost = "localhost"; // Replace By Your Database-Host
		public static $dbuname = "root"; // Replace By Your Database-Username 
<<<<<<< HEAD
		public static $dbpass = "password"; // Replace By Your Database-Password
=======
		public static $dbpass = "1234"; // Replace By Your Database-Password
>>>>>>> a470b63f9e103738c05dcc555176f0ba2f1802b6
		public static $dbname = "freeEdu"; // Standard Database Name Donot change It!
		public static $branchtab = "MBRANCHT";
		public static $regtab = "MREGT";
		public static $brnname = "brname";
		public static $regname = "regname";
		public static $battab = "MBATCHT";
		public static $batname = "battab";
		public static $batsuffix = "batprefix";
		public static $subtab = "MSUBJECTT";
		public static $subname = "subtab";
		public static $fbappid = '214321525295998';
		public static $fbsecret = 'f0f2a47130be5e26756d13f10eaad03c';
		
	}
	class Methods
	{
		public static function getBatchAddString($batchname)
		{
			return "create table ".$batchname."(sid text,srno text,sname text,scontact text,sbio text,imgid text)";		
		}	
		public static function subAddString($subname)
		{
			return "create table ".$subname."(subid text,subcode text,subname text,imgid text,year text,inmax text,exmax text,exmin text,cre text,books text)";		
		}	
		public static function getBranchId($branchname)
		{
			return "select brid from MBRANCHT where brname='".$branchname."'";	
		}	
		public static function getRegId($regname)
		{
			return "select regid from MREGT where regname='".$regname."'";	
		}	
	
	
	}
?>
