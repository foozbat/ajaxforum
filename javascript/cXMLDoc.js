//<!--

cXMLDoc = function ()
{
	this._loaded = false;

	this.selectNodes = function (sNodeName)
	{
		if (/*!this._loaded
			||*/
			null == this._doc)
			return null;

		return this._doc.getElementsByTagName(sNodeName);
	}

	this._docLoaded = function ()
	{
		this._doc = this._preloaddoc;
		this._loaded = true;
	}

	this.loadXml = function (sXml)
	{
		// mozilla
		if (document.implementation &&
			document.implementation.createDocument)
		{
			//this._preloaddoc = document.implementation.createDocument("","",null);
			//this._preloaddoc.onload=this._docLoaded;
			var parser = new DOMParser();
			this._doc = parser.parseFromString(sXml, "text/xml");
		}
		// ie
		else if (window.ActiveXObject)
		{
			this._doc = new ActiveXObject("Microsoft.XMLDOM");
			this._doc.async=false;
			this._doc.loadXML(sXml);
			//this._docLoaded();
		}
		else
		{
			// ...
		}

		//alert(this._preloaddoc);
	}
}

//-->