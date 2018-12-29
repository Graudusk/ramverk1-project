--
-- Creating a sample table.
--


        -- text
        -- användare
        -- skapad
        -- uppdaterad
        -- till (fråga/svar)
        -- frågeid

--
-- Table Comment
--
DROP TABLE IF EXISTS Comment;
CREATE TABLE Comment (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "text" TEXT NOT NULL,
    "user" INT,
    "type" TEXT,
    "post" INT,
    "created" TIMESTAMP,
    "updated" DATETIME
);
