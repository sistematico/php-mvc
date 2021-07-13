create table users
(
    id       INTEGER
        primary key,
    login    TEXT,
    email    TEXT,
    password TEXT,
    fullname TEXT,
    avatar   TEXT,
    role     TEXT default 'user',
    created  REAL default CURRENT_TIMESTAMP,
    access   TEXT,
    gender   text,
    bio      text,
    verified text default 'N',
    plan     text default 'basic',
    valid    text default CURRENT_TIMESTAMP
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


