```js
var str = "";
for (let val of ['a','b','c']) {
  str += val;
}

console.log(str);
// expected output: "abc"

for(var i in arr){

}

//-----

var array = [1, 2, 3, 4];
for (var k = 0, length = array.length; k < length; k++) {
 alert(array[k]);
}

//-----

arr.forEach(function (value, key, arr) {
    // ...
});

//-----

if (typeof Array.prototype.forEach != "function") {
    Array.prototype.forEach = function() {
        /* 实现 */
    };
}

//-----

var Squares = [1,3,4].map(function(val,index,arr){
 console.log(arr[index]==val);  // ==> true
 return val*val           
})
console.log(Squares);        // ==> [1, 9, 16]
```
