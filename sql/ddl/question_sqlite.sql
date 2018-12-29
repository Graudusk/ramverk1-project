--
-- Creating a sample table.
--



--
-- Table Question
--
DROP TABLE IF EXISTS Question;
CREATE TABLE Question (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "title" TEXT NOT NULL,
    "question" TEXT NOT NULL,
    "user" INT,
    "tags" TEXT,
    "slug" TEXT,
    "created" TIMESTAMP,
    "updated" DATETIME
    -- "deleted" DATETIME,
    -- "active" DATETIME
);


-- --
-- -- Table Answer
-- --
-- DROP TABLE IF EXISTS Answer;
-- CREATE TABLE Answer (
--     "id" INTEGER PRIMARY KEY NOT NULL,
--     -- "title" TEXT NOT NULL,
--     "text" TEXT NOT NULL,
--     "user" INT,
--     "question" INT,
--     "created" TIMESTAMP,
--     "updated" DATETIME
-- );

--
-- Table Comment
--
DROP TABLE IF EXISTS Comment;
CREATE TABLE Comment (
    "id" INTEGER PRIMARY KEY NOT NULL,
    -- "title" TEXT NOT NULL,
    "text" TEXT NOT NULL,
    "user" INT,
    "created" TIMESTAMP,
    "updated" DATETIME
    "type" TEXT,
    "question" INT
);
