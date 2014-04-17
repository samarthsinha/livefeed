var redis    = require('redis').createClient()
  , server   = require('http').createServer()
  , io       = require('socket.io').listen(server)
  , cookie   = require('cookie')
  , sockets  = {};


// run HTTP server on this port
server.listen(8090);

// only allow authenticated connections
io.set('authorization', function(handshake, callback)
{
  var cookies = cookie.parse(handshake.headers.cookie);
  redis.get('sessions/' + cookies.PHPSESSID, function(error, result)
  {
    if (error)
    {
      callback(error, false);
    }
    else if (result)
    {
      handshake.session = JSON.parse(result);
      console.log(handshake.session);
      callback(null, true);
    }
    else
    {
      callback('Could not find session ID ' + cookies.PHPSESSID + ' in redis', false);
    }
  });
});

io.sockets.on('connection', function(socket) 
{
  var session = socket.handshake.session;
  console.log('Received connection from user:', session.user_uname);
  // store user's socket
  sockets[session.user_id] = socket;
  console.log("Socket binded with " + session.user_id + " " + socket);
});
getNews();
function getNews()
{
  redis.blpop('news', 0, function(err, data)
  {
    news = JSON.parse(data[1]);
    console.log(news);
    if (typeof news.to !== 'undefined')
    {
      if (typeof sockets[news.to] !== 'undefined')
      {
        // send just the given user the news
        sockets[news.to].emit('news', news.content);
      }
    }
    else
    {
      // send everyone the news
      io.sockets.emit('news', news.content);
    }

    // check for more data in next run of the event loop
    process.nextTick(getNews);
  });
}