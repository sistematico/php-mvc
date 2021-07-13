create table users
(
    id       INTEGER
        primary key,
    login    TEXT,
    email    TEXT,
    password TEXT,
    fullname TEXT,
    gender   text,
    avatar   TEXT,
    bio      text,
    role     TEXT default 'user',
    plan     text default 'basic',
    valid    text default CURRENT_TIMESTAMP,
    verified text default 'N',
    access   TEXT,
    updated  TEXT,
    created  REAL default CURRENT_TIMESTAMP
);

create table posts
(
    id          INTEGER
        primary key,
    author_id   INTEGER
        references users,
    title       INTEGER,
    description TEXT,
    image       TEXT,
    likes       INTEGER,
    created     TEXT default CURRENT_TIMESTAMP,
    updated     TEXT
);

create table comments
(
    id      INTEGER
        primary key,
    post_id INTEGER
        references posts,
    author  TEXT,
    comment INTEGER,
    created TEXT default CURRENT_TIMESTAMP,
    updated TEXT
);


