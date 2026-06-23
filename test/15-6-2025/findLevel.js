function findLevelOrder(node){
    let front= 0;//1 //2 //3
    let result=[];//[[1],[2,9]]
    let queue = [node];//[]
    while(front< queue.length){//0<1  //1<3
        let level =[];//[2,9]
        let size= queue.length - front; //1-0=1 
        for (let i =0 ; i< size ; i++){//i =0,1,2
            let node = queue[front++];//queue[0]=>1 
            level.push(node.val);
            if(node.left){
            queue.push(node.left);
            }
            if(node.right){
                queue.push(node.right);
            }
        }
        result.push(level);
    }
    return result;
}
let node = {
    val: 1, left: {
        val : 2 ,
        left : {
            val : 3,
            left :{
                val : 4,
                left : null,
                right : null
            },
            right : {
                val : 5,
                left : null,
                right : null
            }
        },
        right : {
            val : 6,
            left :{
                val : 7,
                left : null,
                right : null
            },
            right : {
                val : 8,
                left : null,
                right : null
            }
        }

    },right:{
        val : 9,
            left :{
                val : 10,
                left : null,
                right : null
            },
            right : {
                val : 11,
                left : null,
                right : null
            }
        }
        

};
console.log(findLevelOrder(node));