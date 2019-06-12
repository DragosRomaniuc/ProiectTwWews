const url = require('url');
const News = require('./models/News');
const Users = require('./models/User');
const ObjectId = require('mongodb').ObjectID;
exports.setUserNews = async (req, res) => {
    const reqUrl = url.parse(req.url, true);
    var name = 'World';
    if (reqUrl.query.name) {
        name = reqUrl.query.name
    }


    body = '';

    req.on('data', function (chunk) {
        body += chunk;
    });

    req.on('end', async function () {
        try{
        postBody = JSON.parse(body);
        console.log(postBody)
        // var response = {
        //     "text": "Post Request Value is  " + postBody.value
        // };
        const user = await Users.findOne({name: postBody.name});
        if(user){
            Users.findOne({name:postBody.name})
            // .populate('News')
            .exec((err,result)=>{
                if(err) {
                    res.statusCode = 200;
                res.setHeader('Content-Type', 'application/json');
                res.end(JSON.stringify("EROARE"));
                }
                const {category,author,description,content,title,url,urlToImage} = postBody;

                console.log(result);
                let newNews = new News({
                  category,author,description,content,title,url,urlToImage
                })

                newNews.save();

                result.news.push(ObjectId(newNews._id));
                result.save();
                res.statusCode = 200;
                res.setHeader('Content-Type', 'application/json');
                res.end(JSON.stringify(result));
            })
        }else{
            let newUser = new Users({
                name: postBody.name
            })

            await newUser.save();
            res.statusCode = 200;
            res.setHeader('Content-Type', 'application/json');
            res.end(JSON.stringify(newUser));
            console.log(newUser);
        }
    }catch(err){
        console.log(err);
    }

        // const newSeries = new Series({
        //     name: postBody.name,
        //     description: postBody.description
 
        //  });
         
        //  await newSeries.save();

       
    });


    // res.statusCode = 200;
    // res.setHeader('Content-Type', 'application/json');
    // res.end(JSON.stringify(response));
};

exports.getTopics = async (req, res) => {
    const reqUrl = url.parse(req.url, true);
    console.log(reqUrl)
    let id = reqUrl.pathname.split("/").pop();
    
    body = '';

    req.on('data', function (chunk) {
        body += chunk;
    });

    req.on('end', async function () {

        postBody = JSON.parse(body);
        // console.log(JSON.parse(body),"aicisa")
        // console.log("POSTBODY IS",postBody)

        let response = Users.find({name: postBody.name}).populate("news").exec(async (err,user)=>{
            res.statusCode = 200;
            // let x = user.distinct("category");
            // let distinctCategories =  await News.distinct("category");
            let distinctCat = [];
            user[0].news.map(it=>distinctCat.includes(it.category)? '' : distinctCat.push(it.category));
            // let userTopics = 
            let news = {}
            distinctCat.map(dist=>news[dist]=[]);
            user[0].news.map(it=>news[it.category] = [...news[it.category],it]);
            res.setHeader('Content-Type', 'application/json');
            res.end(JSON.stringify(news));
        })

       
        // res.end(JSON.stringify(response));
    });
};

exports.getAllSeries = async(req, res) => {
    body = '';

    req.on('data', function (chunk) {
        body += chunk;
    });

    req.on('end', async function () {

       let resp = await Series.find({});

        res.statusCode = 200;
        res.setHeader('Content-Type', 'application/json');
        res.end(JSON.stringify(resp));
    });
};


exports.deleteSeries = async (req, res) => {
    const reqUrl = url.parse(req.url, true);
    console.log(reqUrl)
    let id = reqUrl.pathname.split("/").pop();
    
    body = '';

    req.on('data', function (chunk) {
        body += chunk;
    });

    req.on('end', async function () {

        postBody = JSON.parse(body);

        let response = await Series.findByIdAndDelete({_id: id});


        res.statusCode = 200;
        res.setHeader('Content-Type', 'application/json');
        res.end(JSON.stringify(response));
    });
};



exports.invalidRequest = function (req, res) {
    // console.log(req,'asd')
    body = '';

    req.on('data', function (chunk) {
        body += chunk;
    });
    console.log(body,'body is')
    res.statusCode = 404;
    res.setHeader('Content-Type', 'text/plain');
    res.end(body);
};