import {ajax} from "../shared/functions/ajax";
import {coreInit} from "../shared/coreInit";

document.addEventListener('DOMContentLoaded', () => {

	document.querySelector("#importDemographicsBtn").addEventListener("click", (e) => {
		e.preventDefault();
		alert("clicked btn1");
	});

	document.querySelector("#resetImportBtn").addEventListener("click", (e) => {
		e.preventDefault();
		ajax(coreInit.applicationUrl + '/admin/imports',
			{
				method: "POST",
				body: {
					test: "Test"
				},
				beforeSend: (xhrObject, headers) => {
					// console.log(xhrObject);
					// console.log(headers);
					// xhrObject.abort();
				},
				afterSend: (xhrObject, statusCode, statusText, status) => {
					// console.log(xhrObject);
					// console.log(statusCode);
					// console.log(statusText);
					// console.log(status);
					// xhrObject.abort();
				},
				success: (data, textStatus) => {
					console.log(data);
					// console.log(textStatus);
				},
				error: (xhrObject, textStatus, error) => {
					// console.log(xhrObject);
					// console.log(textStatus);
					// console.log(error);
				},
				complete: (xhrObject, textStatus) => {
					// console.log(xhrObject);
					// console.log(textStatus);
				},
				statusCode: {
					400: () => {
						console.log("Here")
					}
				}
			}
		);
		alert("clicked btn2");

	});

});

