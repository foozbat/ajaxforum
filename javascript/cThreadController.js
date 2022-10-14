//<!--

cThreadController = function ()
{
	this.updateThreadCallback = function (msg)
	{
		var template = document.getElementById("post_template").innerHTML;
		var divPosts = document.getElementById("divPosts");

		var doc = new cXMLDoc();
		doc.loadXml(msg);

		// process any thread-level stuff from the message here...

		// process posts in the returned message
		var nodes = doc.selectNodes("post");
		var renderer = new cThreadRenderer();
		renderer.renderPosts(nodes, template, divPosts, true);
	}

	this.updateThread = function (threadID)
	{
		var sRemoteUrl = "http://www.hit-squad.net/ajaxforum/ajax/ajax_viewthread.php?id="+threadID;
		var req = new cXMLHttpReq(this.updateThreadCallback);
		req.get(sRemoteUrl);
	}
}

//-->