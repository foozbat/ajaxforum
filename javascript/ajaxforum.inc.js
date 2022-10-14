//<!--

// the ajaxforum object
var g_ajf = window;

// collection of javascript files that have been "included"
g_ajf.loadedModules = new Array();

// the XMLHttpRequest wrapper is placed here because it is needed in order to do just about everything else (i.e. includes)
cXMLHttpReq = function (callback)
{
	this.setCallback = function (callback)
	{
		this._callback = callback;
	}

	this.get = function (url)
	{
		if (null != this._req
			&&
			null != this._callback
			&&
			null != url
			&&
			0 < url.length)
		{
			var req = this._req;
			var cb = this._callback;

			this._req.onreadystatechange = function ()
			{
				// if xmlhttp shows "loaded"
				if (req.readyState==4)
				{
					// if "OK"
					if (req.status==200)
					{
						this._response = req.responseText;
						cb(this._response);
					}
					else
					{
						cb("onreadystatechange(): error retrieving XML data, status = " + req.status);
					}
				}
			};
			this._req.open("GET",url,true);
			this._req.send(null);
		}
	}

	this.init = function (callback)
	{
		// mozilla
		if (window.XMLHttpRequest)
		{
			this._req = new XMLHttpRequest();
		}
		// ie
		else if (window.ActiveXObject)
		{
			this._req = new ActiveXObject("Microsoft.XMLHTTP");
		}

		this.setCallback(callback);
	}
	this.init(callback);
}

g_ajf.evalModule = function (module)
{
	g_ajf.eval(module);
}

function callback (text)
{
	g_ajf.evalModule(text);
}

g_ajf.loadURL = function (url)
{
	var req = new cXMLHttpReq(callback);
	req.get(url);
}

g_ajf.include = function (url)
{
	loadURL(url);
	g_ajf.loadedModules[url] = true;
}

// include components of this "package"
g_ajf.include("javascript/cXMLDoc.js");
g_ajf.include("javascript/cThreadRenderer.js");
g_ajf.include("javascript/cThreadController.js");

//-->