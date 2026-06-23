// BFS(start):

//     Create queue
//     Create visited set

//     Add start to queue
//     Mark start as visited

//     While queue is not empty:

//         Remove first node from queue

//         Process current node

//         For each neighbor:

//             If not visited:

//                 Mark visited
//                 Add to queue

function findLevelOrder(root) {
    let result = []; //[[1]] //[[1],[2,9]] //[[1],[2,9],[3,6,10,11],
    let queue = [root];  //1 //[2,9] //[3,6,10,11]
    while (queue.length > 0) {  //1>0 //3>0 //4>0
        let level = [];
        let levelSize = queue.length;  //1 //3 //4
        for(let i = 0; i < levelSize; i++) {
            let node = queue.shift(); //node= {1,} //node={2,} //node={9,} //3 //6 //10 //11
            // console.log(node); 
            level.push(node.val); //[1] //[2] //[2,9] //[3]  //[3,6] //[3,6,10] //[3,6,10,11]
            if(node.left) {
                queue.push(node.left);  //[2]  //[9,3] //[3,6,10] //[6,10,11,4] //[10,11,4,7] //[11,4,7] //[4,7]
            }
            if(node.right) {
                queue.push(node.right); //[2,9] //[9,3,6] //[3,6,10,11] //[6,10,11,4,5] //[10,11,4,7,8] //[11,4,7] ////[4,7]
            }
        }
        result.push(level); //[1] //[2,9] //[3,6,10,11]
        // console.log(result);
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
