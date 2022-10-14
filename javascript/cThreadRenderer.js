//<!--

cThreadRenderer = function ()
{
	this.renderPosts = function (posts, template, divPosts, bClearExisting)
	{
		if (bClearExisting)
		{
			divPosts.innerHTML = "";
		}

		if (null == posts
			||
			!(posts instanceof HTMLCollection))
		{
			return;
		}

		for (var i = 0; i < posts.length; i++)
		{
			var node = posts[i];
			var sPosterName = node.getElementsByTagName("poster_name")[0].firstChild.nodeValue;
			//var sPosterTitle = node.getElementsByTagName("poster_title")[0].firstChild.nodeValue;
			var sMessage = node.getElementsByTagName("message_text")[0].firstChild.nodeValue;
			var sNumPosts = node.getElementsByTagName("poster_num_posts")[0].firstChild.nodeValue;

			var sPostHTML = template;
			sPostHTML = sPostHTML.replace("~%poster_name%~",sPosterName);
			//sPostHTML.replace("~%poster_title%~",sPosterTitle);
			sPostHTML = sPostHTML.replace("~%message_text%~",sMessage);
			sPostHTML = sPostHTML.replace("~%poster_num_posts%~",sNumPosts);

			var divPost = document.createElement("div");
			divPost.innerHTML = sPostHTML;

			divPosts.appendChild(divPost);
		}
	}
}

//-->