const hostname = '127.0.0.1';
const port = 3000;

const server = require('./controller.js');

server.listen(port, hostname, () => {
    console.log(`Server running at http://${hostname}:${port}/`);
});

// !!!!!!!!!!! NPM INSTALL FIRST
//  NPM INSTALL FIRST

// // api is

// /series/deleteid/5cf0f5daa5575f572451a028   GET 
// /series/searchid/5cf0f5daa5575f572451a028   delete
// /series   { name: 'nume', description:'descriere'} POST
// /series GET