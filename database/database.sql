create table users
(
    id       INTEGER primary key,
    login    TEXT,
    email    TEXT,
    password TEXT,
    avatar   TEXT,
    fullname TEXT,
    bio      TEXT,
    gender   TEXT,
    role     TEXT default 'user',
    plan     TEXT default 'basic',
    valid    TEXT default CURRENT_TIMESTAMP,
    verified TEXT default 'N',
    access   TEXT,
    created  TEXT,
    created  TEXT default CURRENT_TIMESTAMP
);

create table posts
(
    id          INTEGER primary key,
    author_id   INTEGER references users,
    title       TEXT,
    description TEXT,
    image       TEXT,
    likes       INTEGER,
    updated     TEXT,
    created     TEXT default CURRENT_TIMESTAMP
);

create table comments
(
    id      INTEGER primary key,
    post_id INTEGER references posts,
    author  TEXT,
    comment INTEGER,
    created TEXT default CURRENT_TIMESTAMP,
    updated TEXT
);

create table chats
(
    id      INTEGER primary key,
    post_id INTEGER references posts,
    author  TEXT,
    comment INTEGER,
    created TEXT default CURRENT_TIMESTAMP,
    updated TEXT
);

create table messages
(
    id      INTEGER primary key,
    post_id INTEGER references posts,
    author  TEXT,
    comment INTEGER,
    created TEXT default CURRENT_TIMESTAMP,
    updated TEXT
);


