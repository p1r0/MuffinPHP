//depencies: Queue.js jquery.js

var ajaxQueue = null;
var ajaxQueueIsRunning = false;

function ajaxRunLater(ajaxObj)
{
	if(ajaxQueue == null)
	{
		ajaxQueue = new Queue();
	}
	
	var callback = ajaxObj.success;
	
	ajaxObj.success = function(data)
	{
		if(!ajaxQueue.empty())
		{
			ajaxRun();
		}
		else
		{
			ajaxQueueIsRunning = false;
		}
		var fun = function()
		{
			hideAjaxLoader();
		};
		setTimeout(fun, 100);

		callback(data);
	}
	
	ajaxObj.error = function(XMLHttpRequest, textStatus, errorThrown)
	{
		flashMessage('ERROR: there was an error and the request was not completed.');
		if(!ajaxQueue.empty())
		{
			ajaxRun();
		}
		else
		{
			ajaxQueueIsRunning = false;
		}
		var fun = function()
		{
			hideAjaxLoader();
		};
		setTimeout(fun, 100);
	}
	
	ajaxQueue.push(ajaxObj);
	if(!ajaxQueueIsRunning)
	{
		ajaxRun();
	}
}

function ajaxRun()
{
	var ajaxObj = ajaxQueue.pop();
	if((typeof(ajaxObj.noLoader) != "undefined" && ajaxObj.noLoader != true) || (typeof(ajaxObj.noLoader) == "undefined"))
	{	
		var msg = '';
		if(typeof(ajaxObj.loaderMessage) != "undefined")
		{
			msg = ajaxObj.loaderMessage;
		}
		var fun = function()
		{
			showAjaxLoader(msg);
		};
		setTimeout(fun, 100);
	}
	
	ajaxQueueIsRunning = true;
	$.ajax(ajaxObj);
}
