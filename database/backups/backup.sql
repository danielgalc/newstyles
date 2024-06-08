--
-- PostgreSQL database dump
--

-- Dumped from database version 15.6
-- Dumped by pg_dump version 15.6

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: pgcrypto; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;


--
-- Name: EXTENSION pgcrypto; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: bloqueos_peluqueros; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bloqueos_peluqueros (
    id bigint NOT NULL,
    peluquero_id bigint NOT NULL,
    fecha date NOT NULL,
    horas json,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.bloqueos_peluqueros OWNER TO postgres;

--
-- Name: bloqueos_peluqueros_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.bloqueos_peluqueros_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bloqueos_peluqueros_id_seq OWNER TO postgres;

--
-- Name: bloqueos_peluqueros_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.bloqueos_peluqueros_id_seq OWNED BY public.bloqueos_peluqueros.id;


--
-- Name: carrito_items; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.carrito_items (
    id bigint NOT NULL,
    carrito_id bigint NOT NULL,
    producto_id bigint NOT NULL,
    cantidad integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.carrito_items OWNER TO postgres;

--
-- Name: carrito_items_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.carrito_items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.carrito_items_id_seq OWNER TO postgres;

--
-- Name: carrito_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.carrito_items_id_seq OWNED BY public.carrito_items.id;


--
-- Name: carritos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.carritos (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.carritos OWNER TO postgres;

--
-- Name: carritos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.carritos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.carritos_id_seq OWNER TO postgres;

--
-- Name: carritos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.carritos_id_seq OWNED BY public.carritos.id;


--
-- Name: citas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.citas (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    peluquero_id bigint NOT NULL,
    servicio character varying(255) NOT NULL,
    fecha date NOT NULL,
    hora time(0) without time zone NOT NULL,
    estado character varying(255) DEFAULT 'pendiente'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT citas_estado_check CHECK (((estado)::text = ANY ((ARRAY['pendiente'::character varying, 'aceptada'::character varying, 'cancelada'::character varying, 'finalizada'::character varying])::text[])))
);


ALTER TABLE public.citas OWNER TO postgres;

--
-- Name: citas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.citas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.citas_id_seq OWNER TO postgres;

--
-- Name: citas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.citas_id_seq OWNED BY public.citas.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.failed_jobs_id_seq OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- Name: pedido_producto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pedido_producto (
    id bigint NOT NULL,
    pedido_id bigint NOT NULL,
    producto_id bigint NOT NULL,
    cantidad integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.pedido_producto OWNER TO postgres;

--
-- Name: pedido_producto_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pedido_producto_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pedido_producto_id_seq OWNER TO postgres;

--
-- Name: pedido_producto_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pedido_producto_id_seq OWNED BY public.pedido_producto.id;


--
-- Name: pedidos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pedidos (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    precio_total numeric(10,2) NOT NULL,
    fecha_compra date NOT NULL,
    dni character varying(255) NOT NULL,
    telefono character varying(255) NOT NULL,
    direccion character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.pedidos OWNER TO postgres;

--
-- Name: pedidos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pedidos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pedidos_id_seq OWNER TO postgres;

--
-- Name: pedidos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pedidos_id_seq OWNED BY public.pedidos.id;


--
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.personal_access_tokens_id_seq OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- Name: productos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.productos (
    id bigint NOT NULL,
    nombre character varying(255) NOT NULL,
    descripcion character varying(255) NOT NULL,
    precio numeric(8,2) NOT NULL,
    imagen character varying(255) DEFAULT '1'::character varying,
    stock integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    categoria character varying(255)
);


ALTER TABLE public.productos OWNER TO postgres;

--
-- Name: productos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.productos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.productos_id_seq OWNER TO postgres;

--
-- Name: productos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.productos_id_seq OWNED BY public.productos.id;


--
-- Name: servicios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.servicios (
    id bigint NOT NULL,
    nombre character varying(255) NOT NULL,
    precio numeric(8,2) NOT NULL,
    duracion character varying(255) NOT NULL,
    clase character varying(255) DEFAULT 'principal'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.servicios OWNER TO postgres;

--
-- Name: servicios_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.servicios_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.servicios_id_seq OWNER TO postgres;

--
-- Name: servicios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.servicios_id_seq OWNED BY public.servicios.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    rol character varying(255) DEFAULT 'cliente'::character varying NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    dni character varying(255),
    telefono character varying(255),
    direccion character varying(255)
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: bloqueos_peluqueros id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bloqueos_peluqueros ALTER COLUMN id SET DEFAULT nextval('public.bloqueos_peluqueros_id_seq'::regclass);


--
-- Name: carrito_items id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrito_items ALTER COLUMN id SET DEFAULT nextval('public.carrito_items_id_seq'::regclass);


--
-- Name: carritos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carritos ALTER COLUMN id SET DEFAULT nextval('public.carritos_id_seq'::regclass);


--
-- Name: citas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.citas ALTER COLUMN id SET DEFAULT nextval('public.citas_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: pedido_producto id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido_producto ALTER COLUMN id SET DEFAULT nextval('public.pedido_producto_id_seq'::regclass);


--
-- Name: pedidos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos ALTER COLUMN id SET DEFAULT nextval('public.pedidos_id_seq'::regclass);


--
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- Name: productos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productos ALTER COLUMN id SET DEFAULT nextval('public.productos_id_seq'::regclass);


--
-- Name: servicios id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.servicios ALTER COLUMN id SET DEFAULT nextval('public.servicios_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: bloqueos_peluqueros; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.bloqueos_peluqueros (id, peluquero_id, fecha, horas, created_at, updated_at) FROM stdin;
22	5	2024-06-12	"[\\"10:00:00\\",\\"11:00:00\\",\\"19:00:00\\",\\"20:00:00\\"]"	2024-06-04 22:30:35	2024-06-04 22:30:35
15	5	2024-06-07	"[\\"10:00:00\\",\\"11:00:00\\",\\"12:00:00\\",\\"17:00:00\\",\\"18:00:00\\"]"	2024-06-04 16:22:39	2024-06-05 13:35:08
21	5	2024-06-10	"[\\"13:00:00\\"]"	2024-06-04 22:30:02	2024-06-05 14:03:46
27	5	2024-06-26	"[\\"10:00:00\\",\\"11:00:00\\",\\"12:00:00\\"]"	2024-06-05 14:22:06	2024-06-05 14:22:06
35	4	2024-06-26	"[\\"10:00:00\\",\\"11:00:00\\",\\"12:00:00\\",\\"13:00:00\\"]"	2024-06-05 14:27:04	2024-06-05 14:27:04
37	4	2024-06-19	"[\\"10:00:00\\",\\"11:00:00\\",\\"12:00:00\\",\\"13:00:00\\",\\"16:00:00\\",\\"17:00:00\\",\\"18:00:00\\",\\"19:00:00\\",\\"20:00:00\\"]"	2024-06-05 16:21:50	2024-06-05 16:21:50
25	4	2024-06-20	"[\\"10:00:00\\",\\"11:00:00\\",\\"12:00:00\\",\\"13:00:00\\",\\"16:00:00\\"]"	2024-06-05 13:59:20	2024-06-05 16:43:35
38	4	2024-06-13	"[\\"10:00:00\\",\\"11:00:00\\",\\"12:00:00\\",\\"13:00:00\\",\\"16:00:00\\",\\"17:00:00\\",\\"18:00:00\\",\\"19:00:00\\",\\"20:00:00\\"]"	2024-06-05 18:26:11	2024-06-05 18:26:11
39	4	2024-06-27	"[\\"10:00:00\\",\\"11:00:00\\",\\"12:00:00\\",\\"13:00:00\\",\\"16:00:00\\",\\"17:00:00\\",\\"18:00:00\\",\\"19:00:00\\",\\"20:00:00\\"]"	2024-06-05 18:26:49	2024-06-05 18:26:49
34	4	2024-06-12	"[\\"12:00:00\\",\\"13:00:00\\",\\"10:00:00\\"]"	2024-06-05 14:25:42	2024-06-06 19:43:40
\.


--
-- Data for Name: carrito_items; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.carrito_items (id, carrito_id, producto_id, cantidad, created_at, updated_at) FROM stdin;
34	2	25	1	2024-06-06 19:49:39	2024-06-06 19:49:39
10	2	24	2	2024-06-06 11:45:15	2024-06-06 19:49:39
11	2	23	2	2024-06-06 11:45:15	2024-06-06 19:49:39
\.


--
-- Data for Name: carritos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.carritos (id, user_id, created_at, updated_at) FROM stdin;
1	1	2024-06-06 11:43:09	2024-06-06 11:43:09
2	8	2024-06-06 11:45:15	2024-06-06 11:45:15
\.


--
-- Data for Name: citas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.citas (id, user_id, peluquero_id, servicio, fecha, hora, estado, created_at, updated_at) FROM stdin;
32	1	4	Alisado Permanente	2024-06-26	18:00:00	aceptada	2024-06-06 18:07:48	2024-06-06 18:20:52
31	1	4	Extensiones de Cabello	2024-06-12	18:00:00	aceptada	2024-06-06 18:07:28	2024-06-06 18:21:10
15	1	5	Extensiones de Cabello	2024-06-07	16:00:00	cancelada	2024-06-05 12:16:57	2024-06-05 12:37:32
19	1	4	Pedicura	2024-06-12	13:00:00	cancelada	2024-06-05 12:47:05	2024-06-05 12:53:11
18	1	5	Coloración	2024-06-12	16:00:00	cancelada	2024-06-05 12:35:56	2024-06-05 12:53:48
17	1	5	Extensiones de Cabello	2024-06-20	13:00:00	cancelada	2024-06-05 12:28:32	2024-06-05 12:53:56
21	1	5	Pedicura	2024-06-25	17:00:00	aceptada	2024-06-05 12:56:43	2024-06-05 12:56:43
22	1	5	Pedicura	2024-06-25	17:00:00	aceptada	2024-06-05 12:57:06	2024-06-05 12:57:06
26	1	5	Depilación	2024-07-10	18:00:00	aceptada	2024-06-05 13:12:34	2024-06-05 13:13:01
25	1	4	Depilación	2024-06-25	18:00:00	aceptada	2024-06-05 13:07:58	2024-06-05 13:19:03
28	1	4	Alisado Permanente	2024-06-12	12:00:00	cancelada	2024-06-05 13:23:37	2024-06-05 13:24:51
20	1	5	Alisado Permanente	2024-06-12	16:00:00	cancelada	2024-06-05 12:56:10	2024-06-05 13:27:50
30	1	4	Extensiones de Cabello	2024-06-20	18:00:00	cancelada	2024-06-05 14:02:12	2024-06-05 14:02:39
16	1	4	Peinado	2024-06-25	16:00:00	cancelada	2024-06-05 12:17:46	2024-06-05 18:05:32
29	1	4	Peinado	2024-06-27	12:00:00	cancelada	2024-06-05 13:23:46	2024-06-05 18:26:47
27	8	4	Coloración	2024-07-12	17:00:00	cancelada	2024-06-05 13:15:14	2024-06-05 18:48:42
24	8	5	Coloración	2024-06-28	12:00:00	aceptada	2024-06-05 13:06:07	2024-06-05 18:53:35
23	8	5	Coloración	2024-06-25	17:00:00	cancelada	2024-06-05 12:58:03	2024-06-06 13:44:46
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
16	2014_10_12_000000_create_users_table	1
17	2014_10_12_100000_create_password_reset_tokens_table	1
18	2019_08_19_000000_create_failed_jobs_table	1
19	2019_12_14_000001_create_personal_access_tokens_table	1
20	2023_11_21_101034_create_productos_table	2
21	2023_11_28_151245_create_citas_table	3
22	2023_12_19_215556_add_clase_to_servicios_table	4
23	2024_05_26_215540_add_categoria_to_productos_table	5
24	2023_11_21_100819_create_servicios_table	6
25	2023_12_04_154556_create_carritos_table	6
26	2024_06_03_211643_create_bloqueos_peluqueros_table	6
27	2024_06_03_221609_create_servicios_table	7
28	2024_06_04_105858_create_bloqueos_peluqueros_table	8
31	2024_06_05_191328_add_columnas_to_users_table	9
33	2024_06_05_204120_create_pedidos_table	10
34	2024_06_06_113405_drop_carritos_table	11
35	2024_06_06_113451_create_carritos_and_carrito_items_table	12
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: pedido_producto; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pedido_producto (id, pedido_id, producto_id, cantidad, created_at, updated_at) FROM stdin;
1	5	20	2	\N	\N
2	5	21	2	\N	\N
3	5	25	3	\N	\N
4	6	25	1	\N	\N
5	6	24	32	\N	\N
6	7	25	1	\N	\N
7	7	24	1	\N	\N
8	7	23	1	\N	\N
9	8	24	2	\N	\N
10	8	23	2	\N	\N
11	8	25	1	\N	\N
\.


--
-- Data for Name: pedidos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pedidos (id, user_id, precio_total, fecha_compra, dni, telefono, direccion, created_at, updated_at, deleted_at) FROM stdin;
5	1	77.00	2024-06-06	12341234B	112233445	Calle Falsa 1	2024-06-06 21:48:00	2024-06-06 21:48:00	\N
6	1	1610.00	2024-06-06	12341234B	112233445	Calle Falsa 1	2024-06-06 21:59:28	2024-06-06 21:59:28	\N
7	1	100.00	2024-06-06	12341234B	112233445	Calle Falsa 1	2024-06-06 22:06:57	2024-06-06 22:06:57	\N
8	1	190.00	2024-06-07	12341234B	112233445	Calle Falsa 1	2024-06-07 09:42:27	2024-06-07 09:42:27	\N
\.


--
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: productos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.productos (id, nombre, descripcion, precio, imagen, stock, created_at, updated_at, categoria) FROM stdin;
6	Cortapelos profesional	Cortapelos de alta precisión para profesionales	45.00	cortapelos-profesional.webp	100	2024-06-04 00:00:28	2024-06-03 22:39:30	categoria1
5	Champú anticaspa	Champú anticaspa para un cuero cabelludo saludable	7.50	champu-anticaspa.jpg	100	2024-06-04 00:00:28	2024-06-03 22:39:36	categoria1
4	Cera moldeadora mate	Cera moldeadora con acabado mate	10.00	cera-moldeadora-mate.jpg	100	2024-06-04 00:00:28	2024-06-03 22:39:41	categoria1
3	Cepillo desenredante	Cepillo para desenredar el cabello sin tirones	8.00	cepìllo-desenredante.jpg	100	2024-06-04 00:00:28	2024-06-03 22:39:48	categoria1
11	Gel fijador extra fuerte	Gel fijador de extra fijación	6.00	gel-fijador-extrafuerte.png	100	2024-06-04 00:00:28	2024-06-03 22:05:48	categoria1
2	Cepillo térmico alisador	Cepillo térmico para alisar el cabello	15.00	cepillo termico alisador.webp	100	2024-06-04 00:00:28	2024-06-03 22:39:52	categoria1
20	Navaja barbero	Navaja de barbero profesional	20.00	navaja-barbero.jpg	105	2024-06-04 00:00:28	2024-06-06 19:53:00	categoria1
21	Peine carbono antiestático	Peine de carbono antiestático	3.50	peine-carbono-antiestatico.jpg	100	2024-06-04 00:00:28	2024-06-06 19:53:04	categoria1
24	Secador pelo profesional	Secador de pelo profesional	50.00	secador-pelo-profesional.jpg	129	2024-06-04 00:00:28	2024-06-07 09:41:30	categoria1
23	Rizador pelo automático	Rizador de pelo automático	40.00	rizador-pelo-automatico.png	102	2024-06-04 00:00:28	2024-06-07 09:41:31	categoria1
25	Spray protector térmico	Spray protector térmico para el cabello	10.00	spray-protector-termico.jpg	104	2024-06-04 00:00:28	2024-06-07 09:41:32	categoria1
1	Aceite capilar nutritivo	Aceite capilar nutritivo de alta calidad	12.50	aceite-capilar-nutritivo.webp	100	2024-06-04 00:00:28	2024-06-03 22:36:41	categoria1
19	Mascarilla reparadora	Mascarilla reparadora para el cabello dañado	14.00	mascarilla-reparadora.webp	104	2024-06-04 00:00:28	2024-06-06 11:18:51	categoria1
22	Plancha pelo ceramica	Plancha para el pelo con placas de cerámica	35.00	plancha-pelo-ceramica.png	100	2024-06-04 00:00:28	2024-06-03 22:36:16	categoria1
26	Tijeras peluquería	Tijeras de peluquería de alta precisión	25.00	tijeras-peluqueria.jpg	104	2024-06-04 00:00:28	2024-06-06 19:53:59	categoria1
18	Mascarilla color violeta	Mascarilla color violeta para teñir el cabello	12.00	mascarilla-color-violeta.jpg	100	2024-06-04 00:00:28	2024-06-03 22:37:29	categoria1
17	Mascarilla color rojo	Mascarilla color rojo para teñir el cabello	12.00	mascarilla-color-rojo.jpg	100	2024-06-04 00:00:28	2024-06-03 22:37:41	categoria1
16	Mascarilla color negro	Mascarilla color negro para teñir el cabello	12.00	mascarilla-color-negro.jpg	100	2024-06-04 00:00:28	2024-06-03 22:37:47	categoria1
15	Mascarilla color azul	Mascarilla color azul para teñir el cabello	12.00	mascarilla-color-azul.jpg	100	2024-06-04 00:00:28	2024-06-03 22:37:53	categoria1
14	Máscara capilar hidratante	Máscara capilar hidratante	11.00	mascara capilar hidratante.jpg	100	2024-06-04 00:00:28	2024-06-03 22:38:07	categoria1
13	Laca fijación fuerte	Laca de fijación fuerte para el cabello	7.00	laca-fijacion-fuerte.jpg	100	2024-06-04 00:00:28	2024-06-03 22:38:14	categoria1
12	Gorro ducha impermeable	Gorro de ducha impermeable	2.00	gorro-ducha-impermeable.jpg	100	2024-06-04 00:00:28	2024-06-03 22:38:36	categoria1
10	Gel nutritivo	Gel de baño nutritivo para la piel	4.00	gel-baño-nutritivo.jpg	100	2024-06-04 00:00:28	2024-06-03 22:38:47	categoria1
9	Espuma voluminizadora	Espuma voluminizadora para dar cuerpo al cabello	9.00	espuma-voluminizadora.jpg	100	2024-06-04 00:00:28	2024-06-03 22:39:02	categoria1
8	Esponja donut	Esponja para hacer moños en forma de donut	3.00	esponja-moño-donut.jpg	100	2024-06-04 00:00:28	2024-06-03 22:39:12	categoria1
7	Crema afeitar hidratante	Crema de afeitar hidratante para una afeitada suave	5.00	crema-afeitar-hidratante.jpg	100	2024-06-04 00:00:28	2024-06-03 22:39:25	categoria1
\.


--
-- Data for Name: servicios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.servicios (id, nombre, precio, duracion, clase, created_at, updated_at) FROM stdin;
2	Coloración	40.00	55	principal	2024-06-04 00:17:06	2024-06-03 22:17:22
9	Depilación	35.00	60	secundario	2024-06-04 00:17:06	2024-06-03 22:17:33
8	Pedicura	30.00	60	secundario	2024-06-04 00:17:06	2024-06-03 22:17:40
7	Manicura	25.00	60	secundario	2024-06-04 00:17:06	2024-06-03 22:17:44
6	Extensiones de Cabello	200.00	45	principal	2024-06-04 00:17:06	2024-06-03 22:17:48
5	Alisado Permanente	100.00	60	principal	2024-06-04 00:17:06	2024-06-03 22:17:52
4	Tratamiento Capilar	50.00	50	principal	2024-06-04 00:17:06	2024-06-03 22:17:56
3	Peinado	20.00	45	principal	2024-06-04 00:17:06	2024-06-03 22:18:03
1	Corte de Cabello	15.00	30	principal	2024-06-04 00:17:06	2024-06-03 22:18:07
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, email_verified_at, password, rol, remember_token, created_at, updated_at, dni, telefono, direccion) FROM stdin;
3	Admin admin	admin@admin.com	2024-06-03 21:47:05	$2y$12$wnqwqJTi/ZGSiHWqCN6kGOLA0j/8xA1sdo83yGFsQGcLC5WyACcJq	admin	\N	2024-06-03 21:46:59	2024-06-03 21:47:05	\N	\N	\N
4	Juan Diego Jurado	juandiegojurado@peluquero.com	2024-06-03 22:42:04	$2y$12$8iBYMYX.oUCFUetM.ts.Y.Be5lmv8nLsnFkCm/qv1OlMSSDmpQEQu	peluquero	\N	2024-06-03 22:18:56	2024-06-03 22:42:04	\N	\N	\N
5	Pepe Pérez	pepeperez@peluquero.com	2024-06-05 11:36:46	$2y$12$ALL2Pmv5/6w4rrCvxLbsEu6vGY1mqA6JKMfeZ.riKN0hafce.vB.2	peluquero	\N	2024-06-04 20:05:45	2024-06-05 11:36:46	\N	\N	\N
6	Juan Antonio	juanantonio@gmail.com	\N	$2y$12$A.u16XPDMZwZSAHftM3nrON9k.z4Fv6uMAQPEufTPK4qsPt4W8ZMS	cliente	\N	2024-06-05 13:48:59	2024-06-05 13:48:59	\N	\N	\N
7	Juan Ramírez	juanramirez@gmail.com	\N	$2y$12$NaKlV.8LCWKopiMtSF1hcOoBRDpq69hb20XC7yrgYZ.I63NntXvha	cliente	\N	2024-06-05 13:49:13	2024-06-05 13:49:13	\N	\N	\N
9	Manolo Marín	manolomarin@gmail.com	2024-06-05 19:28:38	$2y$12$eydpVmSD.HIUY6dAOw2c/uid553/tedQP7SuleOmKx3utyTXWAPw2	cliente	\N	2024-06-05 19:21:02	2024-06-05 19:47:04	13245678B	123456789	Calle Falsa 123
10	Fernando Román	fernandoroman@gmail.com	\N	$2y$12$GhAUym2qlUuumayLs8xG0.Ylflp.grGXuPRwJjEtUhB1rbKpgedjm	cliente	\N	2024-06-05 20:33:11	2024-06-05 20:33:11	13245678A	887766554	Calle Falsa 321
8	Manuel Gallego	manuelgallego@gmail.com	2024-06-05 22:16:55	$2y$12$abtNmuz0qEF2v5FsBcGctOloffsJ6LCSUIJsbZuKyiTns5CUrE1la	cliente	\N	2024-06-05 16:55:44	2024-06-05 22:16:55	\N	\N	\N
11	Ángeles Calderón	angelescalderon@gmail.com	\N	$2y$12$bj.iKVhAniggGfY56e/Fku3KzizJCNx7Dl6YWZEvdfqQ0/Mu91Erq	cliente	\N	2024-06-06 19:12:07	2024-06-06 19:12:07	13334567B	123456777	Calle Falsa 111
12	Manolito Juan	manolitojuan@gmail.com	\N	$2y$12$U.pD0//6oAI.BTz6Lm6Y3enna7ESl8nRsPXvsGBO.6b/yFUdA6zRS	cliente	\N	2024-06-06 19:39:47	2024-06-06 19:39:47	12344444D	123412354	Calle Falsaaaa
1	Daniel Gallego	danielgallego@gmail.com	2024-06-03 21:39:15	$2y$12$nrLBeGLTmfDnVwuqjNFFgeCbNkPBW/BAhPqLcZiv8Ngm8OCmUtZZy	cliente	\N	2024-06-03 21:39:09	2024-06-06 21:44:39	12341234B	112233445	Calle Falsa 1
\.


--
-- Name: bloqueos_peluqueros_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.bloqueos_peluqueros_id_seq', 39, true);


--
-- Name: carrito_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.carrito_items_id_seq', 47, true);


--
-- Name: carritos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.carritos_id_seq', 2, true);


--
-- Name: citas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.citas_id_seq', 32, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 35, true);


--
-- Name: pedido_producto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pedido_producto_id_seq', 11, true);


--
-- Name: pedidos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pedidos_id_seq', 8, true);


--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);


--
-- Name: productos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.productos_id_seq', 33, true);


--
-- Name: servicios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.servicios_id_seq', 10, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 12, true);


--
-- Name: bloqueos_peluqueros bloqueos_peluqueros_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bloqueos_peluqueros
    ADD CONSTRAINT bloqueos_peluqueros_pkey PRIMARY KEY (id);


--
-- Name: carrito_items carrito_items_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrito_items
    ADD CONSTRAINT carrito_items_pkey PRIMARY KEY (id);


--
-- Name: carritos carritos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carritos
    ADD CONSTRAINT carritos_pkey PRIMARY KEY (id);


--
-- Name: citas citas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.citas
    ADD CONSTRAINT citas_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: pedido_producto pedido_producto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido_producto
    ADD CONSTRAINT pedido_producto_pkey PRIMARY KEY (id);


--
-- Name: pedidos pedidos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- Name: productos productos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_pkey PRIMARY KEY (id);


--
-- Name: servicios servicios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.servicios
    ADD CONSTRAINT servicios_pkey PRIMARY KEY (id);


--
-- Name: users users_dni_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_dni_unique UNIQUE (dni);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: users users_telefono_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_telefono_unique UNIQUE (telefono);


--
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- Name: bloqueos_peluqueros bloqueos_peluqueros_peluquero_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bloqueos_peluqueros
    ADD CONSTRAINT bloqueos_peluqueros_peluquero_id_foreign FOREIGN KEY (peluquero_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: carrito_items carrito_items_carrito_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrito_items
    ADD CONSTRAINT carrito_items_carrito_id_foreign FOREIGN KEY (carrito_id) REFERENCES public.carritos(id);


--
-- Name: carrito_items carrito_items_producto_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrito_items
    ADD CONSTRAINT carrito_items_producto_id_foreign FOREIGN KEY (producto_id) REFERENCES public.productos(id);


--
-- Name: carritos carritos_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carritos
    ADD CONSTRAINT carritos_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- Name: citas citas_peluquero_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.citas
    ADD CONSTRAINT citas_peluquero_id_foreign FOREIGN KEY (peluquero_id) REFERENCES public.users(id);


--
-- Name: citas citas_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.citas
    ADD CONSTRAINT citas_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- Name: pedido_producto pedido_producto_pedido_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido_producto
    ADD CONSTRAINT pedido_producto_pedido_id_foreign FOREIGN KEY (pedido_id) REFERENCES public.pedidos(id) ON DELETE CASCADE;


--
-- Name: pedido_producto pedido_producto_producto_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido_producto
    ADD CONSTRAINT pedido_producto_producto_id_foreign FOREIGN KEY (producto_id) REFERENCES public.productos(id) ON DELETE CASCADE;


--
-- Name: pedidos pedidos_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

