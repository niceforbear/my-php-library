/**
 * Make JSON visualization on browser
 * 
 * Based on `JSON.stringify`(https://msdn.microsoft.com/library/cc836459(v=vs.94).aspx)
 * 
 * Example:
 * var obj = {
	num: 1234,
	str: 'string',
	arr: [1,2,3,4],
	obj:{
		name: 'tom',
		age: 10,
		like: ['water','caffee']
		}
	};
 * 
 * jsonViewOutput(syntaxHighlight(JSON.stringify(obj,undefined,4)));
 *
 * Result:
 * {
    "num": 1234,
    "str": "string",
    "arr": [
        1,
        2,
        3,
        4
    ],
    "obj": {
        "name": "tom",
        "age": 10,
        "like": [
            "water",
            "caffee"
        ]
    	}
	}
 */
function jsonViewOutput(inp){
	document.body.appendChild(document.createElement('pre')).innerHTML = inp;
}
function syntaxHighlight(json){
	json = json.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
	return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function(match){
		var cls = 'number';
		if (/^"/.test(match)) {
			if (/:$/.test(match)) {
				cls = 'key';
			} else {
				cls = 'string';
			}
		} else if (/true|false/.test(match)) {
   			cls = 'boolean';
		} else if (/null/.test(match)) {
   			cls = 'null';
		}
		return '<span class="' + cls + '">' + match + '</span>';
	});
}


