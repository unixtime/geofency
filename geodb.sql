CREATE DATABASE geoDB  
  WITH OWNER = geoadmin
       ENCODING = 'UTF8'
       TABLESPACE = pg_default
       CONNECTION LIMIT = -1;
COMMENT ON DATABASE geodb IS 'Apache and PHP authentication Geofency'; 

CREATE TABLE geodata (  
    id integer NOT NULL,
    datetime timestamp(6) without time zone NOT NULL,
    device character varying(200) NOT NULL,
    locationid character varying(200) DEFAULT ''::character varying NOT NULL,
    latitude character varying(20) NOT NULL,
    longitude character varying(20) NOT NULL,
    entry character varying(20) NOT NULL,
    radius real NOT NULL,
    name character varying(200)
);
ALTER TABLE public.geodata OWNER TO geoadmin;

CREATE SEQUENCE geodata_id_seq  
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.geodata_id_seq OWNER TO geoadmin;  
ALTER SEQUENCE geodata_id_seq OWNED BY geodata.id;

CREATE TABLE groups (  
    group_id integer NOT NULL,
    group_name character varying(20) NOT NULL,
    group_desc character varying(200),
    group_permission smallint NOT NULL
);
ALTER TABLE public.groups OWNER TO geoadmin;

CREATE SEQUENCE groups_group_id_seq  
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.groups_group_id_seq OWNER TO geoadmin;  
ALTER SEQUENCE groups_group_id_seq OWNED BY groups.group_id;

CREATE TABLE users (  
    user_id integer NOT NULL,
    username character varying(20) NOT NULL,
    password character varying(40) NOT NULL,
    group_id integer DEFAULT 2 NOT NULL
);
ALTER TABLE public.users OWNER TO geoadmin;

CREATE SEQUENCE users_user_id_seq  
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.users_user_id_seq OWNER TO geoadmin;  
ALTER SEQUENCE users_user_id_seq OWNED BY users.user_id;  
ALTER TABLE ONLY geodata ALTER COLUMN id SET DEFAULT nextval('geodata_id_seq'::regclass);  
ALTER TABLE ONLY groups ALTER COLUMN group_id SET DEFAULT nextval('groups_group_id_seq'::regclass);  
ALTER TABLE ONLY users ALTER COLUMN user_id SET DEFAULT nextval('users_user_id_seq'::regclass);

SELECT pg_catalog.setval('geodata_id_seq', 1, false);  
SELECT pg_catalog.setval('groups_group_id_seq', 1, false);  
SELECT pg_catalog.setval('users_user_id_seq', 1, false);

ALTER TABLE ONLY geodata  
    ADD CONSTRAINT geodata_id_pkey PRIMARY KEY (id);

ALTER TABLE ONLY groups  
    ADD CONSTRAINT groups_pkey PRIMARY KEY (group_id);

ALTER TABLE ONLY users  
    ADD CONSTRAINT users_pkey PRIMARY KEY (user_id);

ALTER TABLE ONLY users  
    ADD CONSTRAINT users_username_key UNIQUE (username);

REVOKE ALL ON SCHEMA public FROM PUBLIC;  
REVOKE ALL ON SCHEMA public FROM postgres;  
GRANT ALL ON SCHEMA public TO postgres;  
GRANT ALL ON SCHEMA public TO PUBLIC;