/**
 * ### Args Params {wwwwww
 * **afterSend()** - Callback function that runs after the request is send, but before the success method.
 *
 * **beforeSend()** - Callback function that runs before fetching the URL.
 *
 * **complete()** - Callback function that runs after success and error callbacks.
 *
 * **contentType** - Content-Type header. Defaults to 'application/json'.
 *
 * **body** - Body of the request. JSON stringifies the property. Can be an object, a single value (string, int), or an array.
 *
 * **dataType** - Data type to be returned. JSON by default. Can be text/html, JSON, blob, or arrayBuffer.
 *
 * **error** - Callback function that runs when there is a problem with the response.
 *
 * **extraHeaders** - Object of additional headers to send in the request.
 *
 * **method** - Fetch method. Defaults to GET.
 *
 * **statusCode** - Object of callback functions that get called depending on the response code returned. By default, it returns the response code as a string.
 *
 * **success** - Callback function that is called if response.ok is true and the data has been returned in the desired format.
 *
 * **timeout** - Set the time in milliseconds allowed for the request. 0 means there will be no timeout. Defaults to 20000.
 *
 * }
 *
 *
 * **Example usage:**
 *
 * ``` JavaScript
 * ajax(coreInit.applicationUrl + '/admin/imports',
 *   {
 * 	  	contentType: "application/x-www-form-urlencoded", // Other option
 * 	  	method: "POST",
 * 	  	dataType: "arrayBuffer",
 * 	  	body: {
 * 	  		test: "Test"
 * 	  	},
 * 	  	extraHeaders: {
 * 	  		'X-Custom-Header': 'Testing123'
 * 	  	},
 * 	  	timeout: 0,
 * 	  	beforeSend: (xhrObject, headers) => {
 * 	  		console.log(xhrObject);
 * 	  		console.log(headers);
 * 	  		xhrObject.abort();
 * 	  	},
 * 	  	afterSend: (xhrObject, statusCode, statusText, status) => {
 * 	  		console.log(xhrObject);
 * 	  		console.log(statusCode);
 * 	  		console.log(statusText);
 * 	  		console.log(status);
 * 	  		xhrObject.abort();
 * 	  	},
 * 	  	success: (data, textStatus) => {
 * 	  		console.log(data);
 * 	  		console.log(textStatus);
 * 	  	},
 * 	  	error: (xhrObject, textStatus, error) => {
 * 	  		console.log(xhrObject);
 * 	  		console.log(textStatus);
 * 	  		console.log(error);
 * 	  	},
 * 	  	complete: (xhrObject, textStatus) => {
 * 	  		console.log(xhrObject);
 * 	  		console.log(textStatus);
 * 	  	},
 * 	    statusCode: {
 * 			400: () => {
 * 				console.log("Here")
 * 			}
 * 		}
 *   }
 * );
 * ```
 *
 *
 * @param url
 * @param args
 * @returns {Promise<boolean>|Promise<Object>}
 */
async function ajax(url, args = {}) {
	const controller = new AbortController();
	const signal = controller.signal;

	const xhrObject = {
		timeout: 20000,
		textStatus: "",
		killProcess: false,
		abort: function() {
			console.log("From abort: ABORT");
			this.textStatus = "abort";
			this.killProcess = true;
		}
	};

	const fetchOptions = {
		method: "GET",
		headers: {
			"Content-Type": "application/json",
		},
		body: null,
		mode: "cors",
		cache: "no-cache",
		credentials: "same-origin",
		redirect: "follow",
		referrerPolicy: "no-referrer",
		signal: signal,
	};
	const defaultArgs = {
		beforeSend: (xhrObject, settings) => {},
		afterSend: (xhrObject, statusCode, statusText, status) => {},
		error: (xhrObject, textStatus, error) => {},
		success: (data, textStatus) => {},
		complete: (xhrObject, textStatus) => {},
		statusCode: {
			400: () => { },
			401: () => { },
			403: () => { },
			404: () => { },
			405: () => { },
			408: () => { },
			500: () => { },
			501: () => { },
			502: () => { },
			504: () => { },
		}
	};

	if (args.method !== undefined) { fetchOptions.method = args.method; }
	if (args.beforeSend !== undefined) { defaultArgs.beforeSend = args.beforeSend; }
	if (args.afterSend !== undefined) { defaultArgs.afterSend = args.afterSend; }
	if (args.error !== undefined) { defaultArgs.error = args.error; }
	if (args.success !== undefined) { defaultArgs.success = args.success; }
	if (args.complete !== undefined) { defaultArgs.complete = args.complete; }
	if (args.contentType !== undefined) { fetchOptions.headers['Content-Type'] = args.contentType; }
	if (args.dataType === undefined) { args.dataType = "JSON"; }
	if (args.timeout !== undefined) { xhrObject.timeout = args.timeout; }
	if (xhrObject.timeout === 0) { xhrObject.timeout = null; }

	if (args.extraHeaders !== undefined) {
		fetchOptions.headers = { ...fetchOptions.headers, ...args.extraHeaders }
	}
	if (fetchOptions.headers['Content-Type'] === 'application/json') {
		fetchOptions.body = JSON.stringify(args.body);
	} else if (fetchOptions.headers['Content-Type'] === 'application/x-www-form-urlencoded') {
		fetchOptions.body = new URLSearchParams(args.body).toString();
	} else {
		fetchOptions.headers['Content-Type'] = 'application/json';
		fetchOptions.body = JSON.stringify(args.body);
	}

	if (args.statusCode !== undefined) {
		for (const code in defaultArgs.statusCode) {
			if (args.statusCode[code] !== undefined && defaultArgs.statusCode.hasOwnProperty(code)) {
				defaultArgs.statusCode[code] = args.statusCode[code];
			}
		}
	}

	let timeoutId;
	if (xhrObject.timeout) {
		timeoutId = setTimeout(() => {
			xhrObject.textStatus = "timed out";
			controller.abort();
		}, xhrObject.timeout);
	} else {
		timeoutId = null;
	}

	try {
		// Call the beforeSend function if provided
		if (typeof defaultArgs.beforeSend === 'function') {
			xhrObject.textStatus = "notmodified";
			await defaultArgs.beforeSend(xhrObject, fetchOptions);
		}

		if (xhrObject.killProcess) {
			return false;
		}

		const response = await fetch(url, fetchOptions);

		// Calls the error function based on the status code if it exists.
		const statusCode = response.status;
		if (defaultArgs.statusCode.hasOwnProperty(statusCode) && typeof defaultArgs.statusCode[statusCode] === "function") {
			defaultArgs.statusCode[statusCode]();
		}

		// Call the afterSend function if provided
		if (typeof defaultArgs.afterSend === 'function') {
			defaultArgs.afterSend(xhrObject, response.status, response.statusText, response.ok);
		}

		if (xhrObject.killProcess) {
			return false;
		}

		if (!response.ok) {
			throw new Error(`${response.status} ${response.statusText}`);
		}

		let data;
		switch (args.dataType) {
			case "JSON":
				data = await response.json();
				break;
			case "text":
			case "html":
			case "text/html":
				data = await response.text();
				break;
			case "blob":
				data = await response.blob();
				break;
			case "arrayBuffer":
				data = await response.arrayBuffer();
				break;
			case "formData":
				data = await response.formData();
				break;
			default:
				if (timeoutId) clearTimeout(timeoutId);
				xhrObject.abort();
				controller.abort();
				break;
		}

		if (xhrObject.killProcess) {
			throw new Error("There was an error with the request.");
		}

		// Call the success function if provided
		if (typeof defaultArgs.success === 'function') {
			xhrObject.textStatus = "success";
			defaultArgs.success(data, xhrObject.textStatus);
		}
	} catch (error) {
		if (typeof defaultArgs.error === 'function') {
			if (xhrObject.textStatus !== "timed out") {
				xhrObject.textStatus = "error";
			}
			defaultArgs.error(xhrObject, xhrObject.textStatus, error);
			if (timeoutId) clearTimeout(timeoutId);
			return false;
		}
	}

	// Call the afterSend function if provided
	if (typeof defaultArgs.complete === 'function') {
		xhrObject.textStatus = "complete";
		xhrObject.killTimer = true;
		defaultArgs.complete(xhrObject, xhrObject.textStatus);
		if (xhrObject.killTimer) {
			if (timeoutId) clearTimeout(timeoutId);
		}
	}
	return xhrObject;
}
export { ajax }