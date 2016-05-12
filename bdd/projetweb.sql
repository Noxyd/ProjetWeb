--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.2
-- Dumped by pg_dump version 9.5.2

-- Started on 2016-05-11 20:39:40

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 1 (class 3079 OID 12355)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2183 (class 0 OID 0)
-- Dependencies: 1
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 181 (class 1259 OID 16494)
-- Name: equipes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE equipes (
    ideq integer NOT NULL,
    nomeq character varying(25)
);


ALTER TABLE equipes OWNER TO postgres;

--
-- TOC entry 182 (class 1259 OID 16497)
-- Name: equipes_ideq_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE equipes_ideq_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE equipes_ideq_seq OWNER TO postgres;

--
-- TOC entry 2184 (class 0 OID 0)
-- Dependencies: 182
-- Name: equipes_ideq_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE equipes_ideq_seq OWNED BY equipes.ideq;


--
-- TOC entry 183 (class 1259 OID 16499)
-- Name: evenements; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE evenements (
    ideven integer NOT NULL,
    intitule character varying(50) NOT NULL,
    dateeven date NOT NULL,
    lieu character varying(100) NOT NULL,
    description text,
    statut integer,
    ideq integer
);


ALTER TABLE evenements OWNER TO postgres;

--
-- TOC entry 184 (class 1259 OID 16505)
-- Name: evenements_ideven_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE evenements_ideven_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE evenements_ideven_seq OWNER TO postgres;

--
-- TOC entry 2185 (class 0 OID 0)
-- Dependencies: 184
-- Name: evenements_ideven_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE evenements_ideven_seq OWNED BY evenements.ideven;


--
-- TOC entry 185 (class 1259 OID 16507)
-- Name: financeur; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE financeur (
    idfin integer NOT NULL,
    nomfinanceur character varying(25),
    description character varying(150)
);


ALTER TABLE financeur OWNER TO postgres;

--
-- TOC entry 186 (class 1259 OID 16510)
-- Name: financeur_idfin_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE financeur_idfin_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE financeur_idfin_seq OWNER TO postgres;

--
-- TOC entry 2186 (class 0 OID 0)
-- Dependencies: 186
-- Name: financeur_idfin_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE financeur_idfin_seq OWNED BY financeur.idfin;


--
-- TOC entry 187 (class 1259 OID 16512)
-- Name: flux; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE flux (
    idflux integer NOT NULL,
    debit double precision,
    credit double precision,
    libelle character varying(50),
    datef date,
    idfin integer,
    ideq integer
);


ALTER TABLE flux OWNER TO postgres;

--
-- TOC entry 188 (class 1259 OID 16515)
-- Name: flux_idflux_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE flux_idflux_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE flux_idflux_seq OWNER TO postgres;

--
-- TOC entry 2187 (class 0 OID 0)
-- Dependencies: 188
-- Name: flux_idflux_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE flux_idflux_seq OWNED BY flux.idflux;


--
-- TOC entry 189 (class 1259 OID 16517)
-- Name: messages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE messages (
    idmessage integer NOT NULL,
    objet character varying(100),
    contenu text,
    dateenvoi character varying(25) NOT NULL,
    etat integer,
    idemetteur integer,
    idrecepteur integer
);


ALTER TABLE messages OWNER TO postgres;

--
-- TOC entry 190 (class 1259 OID 16523)
-- Name: messages_idmessage_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE messages_idmessage_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE messages_idmessage_seq OWNER TO postgres;

--
-- TOC entry 2188 (class 0 OID 0)
-- Dependencies: 190
-- Name: messages_idmessage_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE messages_idmessage_seq OWNED BY messages.idmessage;


--
-- TOC entry 191 (class 1259 OID 16525)
-- Name: publications; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE publications (
    idpub integer NOT NULL,
    titre character varying(200),
    datepub date,
    contenu text,
    etat integer NOT NULL,
    ideq integer
);


ALTER TABLE publications OWNER TO postgres;

--
-- TOC entry 192 (class 1259 OID 16531)
-- Name: publications_idpub_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE publications_idpub_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE publications_idpub_seq OWNER TO postgres;

--
-- TOC entry 2189 (class 0 OID 0)
-- Dependencies: 192
-- Name: publications_idpub_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE publications_idpub_seq OWNED BY publications.idpub;


--
-- TOC entry 193 (class 1259 OID 16533)
-- Name: utilisateurs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE utilisateurs (
    iduser integer NOT NULL,
    nom character varying(50) NOT NULL,
    prenom character varying(50) NOT NULL,
    mail character varying(50) NOT NULL,
    mdp character varying(16) NOT NULL,
    description character varying(200),
    statut integer,
    photo character varying(25),
    ideq integer
);


ALTER TABLE utilisateurs OWNER TO postgres;

--
-- TOC entry 194 (class 1259 OID 16536)
-- Name: utilisateurs_iduser_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE utilisateurs_iduser_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE utilisateurs_iduser_seq OWNER TO postgres;

--
-- TOC entry 2190 (class 0 OID 0)
-- Dependencies: 194
-- Name: utilisateurs_iduser_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE utilisateurs_iduser_seq OWNED BY utilisateurs.iduser;


--
-- TOC entry 2020 (class 2604 OID 16538)
-- Name: ideq; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY equipes ALTER COLUMN ideq SET DEFAULT nextval('equipes_ideq_seq'::regclass);


--
-- TOC entry 2021 (class 2604 OID 16539)
-- Name: ideven; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY evenements ALTER COLUMN ideven SET DEFAULT nextval('evenements_ideven_seq'::regclass);


--
-- TOC entry 2022 (class 2604 OID 16540)
-- Name: idfin; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY financeur ALTER COLUMN idfin SET DEFAULT nextval('financeur_idfin_seq'::regclass);


--
-- TOC entry 2023 (class 2604 OID 16541)
-- Name: idflux; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY flux ALTER COLUMN idflux SET DEFAULT nextval('flux_idflux_seq'::regclass);


--
-- TOC entry 2024 (class 2604 OID 16542)
-- Name: idmessage; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY messages ALTER COLUMN idmessage SET DEFAULT nextval('messages_idmessage_seq'::regclass);


--
-- TOC entry 2025 (class 2604 OID 16543)
-- Name: idpub; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY publications ALTER COLUMN idpub SET DEFAULT nextval('publications_idpub_seq'::regclass);


--
-- TOC entry 2026 (class 2604 OID 16544)
-- Name: iduser; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY utilisateurs ALTER COLUMN iduser SET DEFAULT nextval('utilisateurs_iduser_seq'::regclass);


--
-- TOC entry 2162 (class 0 OID 16494)
-- Dependencies: 181
-- Data for Name: equipes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY equipes (ideq, nomeq) FROM stdin;
1	données
2	ihm
3	développement
\.


--
-- TOC entry 2191 (class 0 OID 0)
-- Dependencies: 182
-- Name: equipes_ideq_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('equipes_ideq_seq', 3, true);


--
-- TOC entry 2164 (class 0 OID 16499)
-- Dependencies: 183
-- Data for Name: evenements; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY evenements (ideven, intitule, dateeven, lieu, description, statut, ideq) FROM stdin;
1	presentation du concept du site	2016-08-10	palais des congres	les equipes travaillant sur le projet feront une presentation générale pour trouver des financement	1	1
2	compagne de recrutement	2016-03-11	palais des congres	les manager seront chargé de selectionner des candidatures  dans le but de recruter	0	2
\.


--
-- TOC entry 2192 (class 0 OID 0)
-- Dependencies: 184
-- Name: evenements_ideven_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('evenements_ideven_seq', 2, true);


--
-- TOC entry 2166 (class 0 OID 16507)
-- Dependencies: 185
-- Data for Name: financeur; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY financeur (idfin, nomfinanceur, description) FROM stdin;
1	irit	institut de recherche
2	thales	industriel
3	région	la region midi pyrénnées
\.


--
-- TOC entry 2193 (class 0 OID 0)
-- Dependencies: 186
-- Name: financeur_idfin_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('financeur_idfin_seq', 3, true);


--
-- TOC entry 2168 (class 0 OID 16512)
-- Dependencies: 187
-- Data for Name: flux; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY flux (idflux, debit, credit, libelle, datef, idfin, ideq) FROM stdin;
1	120000	0	budget materiel	2016-04-01	1	\N
2	0	5000	location locaux	2016-04-01	\N	1
\.


--
-- TOC entry 2194 (class 0 OID 0)
-- Dependencies: 188
-- Name: flux_idflux_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('flux_idflux_seq', 2, true);


--
-- TOC entry 2170 (class 0 OID 16517)
-- Dependencies: 189
-- Data for Name: messages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY messages (idmessage, objet, contenu, dateenvoi, etat, idemetteur, idrecepteur) FROM stdin;
1	dossier de conception	bonjour, le dossier est complet a 85%	10/05/2016 11:01	0	1	3
2	codage bdd	bonjour, la base de données a été codé entierement	10/05/2016 11:01	0	3	1
\.


--
-- TOC entry 2195 (class 0 OID 0)
-- Dependencies: 190
-- Name: messages_idmessage_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('messages_idmessage_seq', 2, true);


--
-- TOC entry 2172 (class 0 OID 16525)
-- Dependencies: 191
-- Data for Name: publications; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY publications (idpub, titre, datepub, contenu, etat, ideq) FROM stdin;
1	dossier de conception de la plateforme	2002-05-01	voici le dossier de notre conception voici le dossier de notre concep	1	1
2	resultat du teste du prototype	2002-05-01	voici les resultat des recherches voici les resultat des recherches	0	2
3	Ceci est une publication	2005-08-27	Ceci est un article issue de la base de donn‚es. Voici son affichage.	1	3
\.


--
-- TOC entry 2196 (class 0 OID 0)
-- Dependencies: 192
-- Name: publications_idpub_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('publications_idpub_seq', 2, true);


--
-- TOC entry 2174 (class 0 OID 16533)
-- Dependencies: 193
-- Data for Name: utilisateurs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY utilisateurs (iduser, nom, prenom, mail, mdp, description, statut, photo, ideq) FROM stdin;
1	nadjim	mehdioui	nadjim@mehdioui	nadjim	salut je suis beau	1	lien1	1
2	samuel	garcia	samuel@garcia	samuel	faire des sites c ‘est ma vie…	0	lien2	3
3	said	sarma	said@sarma	said	à la téte de cybersherif	0	lien3	2
\.


--
-- TOC entry 2197 (class 0 OID 0)
-- Dependencies: 194
-- Name: utilisateurs_iduser_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('utilisateurs_iduser_seq', 3, true);


--
-- TOC entry 2028 (class 2606 OID 16546)
-- Name: equipes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY equipes
    ADD CONSTRAINT equipes_pkey PRIMARY KEY (ideq);


--
-- TOC entry 2030 (class 2606 OID 16548)
-- Name: evenements_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY evenements
    ADD CONSTRAINT evenements_pkey PRIMARY KEY (ideven);


--
-- TOC entry 2032 (class 2606 OID 16550)
-- Name: financeur_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY financeur
    ADD CONSTRAINT financeur_pkey PRIMARY KEY (idfin);


--
-- TOC entry 2034 (class 2606 OID 16552)
-- Name: flux_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY flux
    ADD CONSTRAINT flux_pkey PRIMARY KEY (idflux);


--
-- TOC entry 2036 (class 2606 OID 16554)
-- Name: messages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY messages
    ADD CONSTRAINT messages_pkey PRIMARY KEY (idmessage);


--
-- TOC entry 2038 (class 2606 OID 16556)
-- Name: publications_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY publications
    ADD CONSTRAINT publications_pkey PRIMARY KEY (idpub);


--
-- TOC entry 2040 (class 2606 OID 16558)
-- Name: utilisateurs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY utilisateurs
    ADD CONSTRAINT utilisateurs_pkey PRIMARY KEY (iduser);


--
-- TOC entry 2041 (class 2606 OID 16559)
-- Name: fk_evenements_ideq; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY evenements
    ADD CONSTRAINT fk_evenements_ideq FOREIGN KEY (ideq) REFERENCES equipes(ideq);


--
-- TOC entry 2042 (class 2606 OID 16564)
-- Name: fk_flux_ideq; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY flux
    ADD CONSTRAINT fk_flux_ideq FOREIGN KEY (ideq) REFERENCES equipes(ideq);


--
-- TOC entry 2043 (class 2606 OID 16569)
-- Name: fk_flux_idfin; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY flux
    ADD CONSTRAINT fk_flux_idfin FOREIGN KEY (idfin) REFERENCES financeur(idfin);


--
-- TOC entry 2044 (class 2606 OID 16574)
-- Name: fk_messages_iduser; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY messages
    ADD CONSTRAINT fk_messages_iduser FOREIGN KEY (idemetteur) REFERENCES utilisateurs(iduser);


--
-- TOC entry 2045 (class 2606 OID 16579)
-- Name: fk_messages_iduser_utilisateurs; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY messages
    ADD CONSTRAINT fk_messages_iduser_utilisateurs FOREIGN KEY (idrecepteur) REFERENCES utilisateurs(iduser);


--
-- TOC entry 2046 (class 2606 OID 16584)
-- Name: fk_publications_ideq; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY publications
    ADD CONSTRAINT fk_publications_ideq FOREIGN KEY (ideq) REFERENCES equipes(ideq);


--
-- TOC entry 2047 (class 2606 OID 16589)
-- Name: fk_utilisateurs_ideq; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY utilisateurs
    ADD CONSTRAINT fk_utilisateurs_ideq FOREIGN KEY (ideq) REFERENCES equipes(ideq);


--
-- TOC entry 2182 (class 0 OID 0)
-- Dependencies: 7
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2016-05-11 20:39:41

--
-- PostgreSQL database dump complete
--

