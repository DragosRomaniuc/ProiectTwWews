const url = require('url');
const Series = require('./models/Series');
exports.addSeries = async (req, res) => {
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

        postBody = JSON.parse(body);

        // var response = {
        //     "text": "Post Request Value is  " + postBody.value
        // };

        const newSeries = new Series({
            name: postBody.name,
            description: postBody.description
 
         });
         
         await newSeries.save();

        res.statusCode = 200;
        res.setHeader('Content-Type', 'application/json');
        res.end(JSON.stringify(newSeries));
    });


    // res.statusCode = 200;
    // res.setHeader('Content-Type', 'application/json');
    // res.end(JSON.stringify(response));
};

exports.getSeries = async (req, res) => {
    const reqUrl = url.parse(req.url, true);
    console.log(reqUrl)
    let id = reqUrl.pathname.split("/").pop();
    
    body = '';

    req.on('data', function (chunk) {
        body += chunk;
    });

    req.on('end', async function () {

        postBody = JSON.parse(body);

        let response = await Series.find({_id: id});


        res.statusCode = 200;
        res.setHeader('Content-Type', 'application/json');
        res.end(JSON.stringify(response));
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