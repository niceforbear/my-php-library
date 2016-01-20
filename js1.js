'use strict';


//<script src=""></script>


//Entry console:
var browser = "";
console.log(browser);


//断点、单步执行等高级调试技巧 in Browser


//严格区分大小写


// == 会转换数据类型进行比较， === 不会


//NaN !== NaN
//isNaN(NaN)


//浮点数比较,通过计算误差和绝对值
Math.abs(1 / 3 - (1 - 2 / 3)) < 0.0000001;


null != 0 != ''
// '' 是一个字符串，其长度为0
// null 表示元素为空， undefined 表示元素未定义
// undefined仅在判断函数参数是否传参使用


var arr = [1,2,5.5,'hello',null,null];


var person = {
    'name':'lyk',
    'age':23,
    'tags':['ball','cs'],
    'zipcode':null
};

//var 申明为局部变量


//ES6标准：多行字符串表示方法： 
`this
is
a line`;


//array.join('str') 将数组用str连接成字符串

delete person.zipcode;
'tags' in person;   //也会判断tags属性是否在继承的父类中
person.hasOwnProperty('tags');  //只在自己的对象中查看是否有该元素


//遍历对象中的索引
for(var key in myObj){}


//Map
var scoreList = new Map(['lyk',99],['lym',98]);
scoreList.get('lyk');

var scoreList = new Map();
scoreList.set('key','val');
scoreList.has('key');
scoreList.delete('key');


//Set : set of keys
var nameList= new Set([1,2,3,4]);

var nameList = new Set();
nameList.add(4);
nameList.add('4');


//遍历iterable类型（array, map, set）
for(var index of iter){}


//
var foreachArr = ['val1','val2'];
foreachArr.forEach(function(element, index, arrObj){});

var foreachSet = new Set([1,2]);
foreachSet.forEach(function(element, setObj){});

var foreachMap = new Map(['k1','v1'],['k2','v2']);
foreachMap.forEach(function(value, key, mapObj){});


function abs(x){
    if(typeof x != 'number'){
        throw 'Not a number';
    }
    //..
}


//arguments 获得函数参数作为array， 用于判断 传入参数


// rest : keyword
function foo(a,b,...rest){

}


function foo(){
    function bar(){
    
    }
}

//顶层变量、函数可以被window对象调用


//定义命名空间
var App = {};
App.name = 'myapp';


//块级作用域
function foo(){
    for(let i=0; i<100; i++){}
}


//定义块级作用域
const PI = 3.14;
let PI2 = 3.1415


//method
var lyk = {
    name : 'lyk',
    birth : 1990,
    age : function(){
        return new Date().getFullYear() - this.birth;
    }
}

/* NOTICE : this的指向 */

// apply方法可以定义函数中this的指向
func.apply(objName, []);
func.call(objName, params);


//高阶参数
function high(a,b, func){

}


//map, reduce, filter, sort(func()), 

//闭包：高阶函数return函数 ： 返回函数禁止返回任何 函数中参数变量

var width = window.innerWidth || document.body.clientWidth;



//服务器端对于cookie设置httpOnly


// < IE8 : no support
var q1 = document.querySelector('#q1');
var ps = q1.querySelector('div.highlighted > p');






























