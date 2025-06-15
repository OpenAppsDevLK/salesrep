-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 15, 2025 at 08:52 PM
-- Server version: 5.7.40-log
-- PHP Version: 8.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sales_rep`
--

-- --------------------------------------------------------

--
-- Table structure for table `cp_customers`
--

CREATE TABLE `cp_customers` (
  `id` int(11) NOT NULL,
  `com_id` int(11) DEFAULT NULL,
  `com_name` varchar(255) DEFAULT NULL,
  `com_tele` int(11) DEFAULT NULL,
  `com_address` varchar(255) DEFAULT NULL,
  `com_notes` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cp_customers`
--

INSERT INTO `cp_customers` (`id`, `com_id`, `com_name`, `com_tele`, `com_address`, `com_notes`) VALUES
(11, 6481, 'ABC Shop', 7777777, 'No 10 Colombo', ''),
(14, 3252, 'Welcome Stores', 2147483647, 'dcsd ds', 'fdbfbdf'),
(15, 2124, 'Kamal Stores', 454564465, 'No 258\r\nKalutara', '');

-- --------------------------------------------------------

--
-- Table structure for table `cp_invoice`
--

CREATE TABLE `cp_invoice` (
  `id` int(11) NOT NULL,
  `inv_id` int(11) DEFAULT NULL,
  `inv_cos_id` int(11) DEFAULT NULL,
  `inv_rep_id` int(11) DEFAULT NULL,
  `inv_root_id` int(11) DEFAULT NULL,
  `inv_invoice_date` date DEFAULT NULL,
  `inv_delivery_date` date DEFAULT NULL,
  `inv_total_items` bigint(20) DEFAULT NULL,
  `inv_free_issues` int(11) DEFAULT NULL,
  `inv_gross_total` double(10,2) DEFAULT NULL,
  `inv_return_item_amount` double(10,2) DEFAULT NULL,
  `inv_grand_total` double(10,2) DEFAULT NULL,
  `inv_notes` varchar(255) DEFAULT NULL,
  `customer_signature` text,
  `is_paid` int(11) DEFAULT '0' COMMENT 'Paid-1 | Not Paid-0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cp_invoice`
--

INSERT INTO `cp_invoice` (`id`, `inv_id`, `inv_cos_id`, `inv_rep_id`, `inv_root_id`, `inv_invoice_date`, `inv_delivery_date`, `inv_total_items`, `inv_free_issues`, `inv_gross_total`, `inv_return_item_amount`, `inv_grand_total`, `inv_notes`, `customer_signature`, `is_paid`) VALUES
(23, 2025984963, 11, 2, 1, '2025-06-03', '2025-06-20', 3, 2, 35250.00, 1050.00, 34200.00, 'Notes Notes Notes', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAjoAAADICAYAAADhjUv7AAAAAXNSR0IArs4c6QAAIABJREFUeF7tnQe0FEX2xmtNq65hVRBFBBMICKi4IKuiqyiKuoiRZcGEGAgGwEUQxYiYs6KAYkCU3UXBhAkDYkRWBNYsoijmgFlU/J9frfX+9YZ5M90zPTPdPd895x0Uerqrvuo39dW93733d7/++uuvRiYEhIAQEAJCQAgIgRQi8DsRnRSuqqYkBISAEBACQkAIWAREdPQiCAEhIASEgBAQAqlFQEQntUuriQkBISAEhIAQEAIiOnoHhIAQEAJCQAgIgdQiIKKT2qXVxISAEBACQkAICAERHb0DQkAICAEhIASEQGoRENFJ7dJqYkJACAgBISAEhICIjt4BISAEhIAQEAJCILUIiOikdmk1MSEgBISAEBACQkBER++AEBACQkAICAEhkFoERHRSu7SamBAQAkJACAgBISCio3dACAgBISAEhIAQSC0CIjqpXVpNTAgIASEgBISAEBDR0TsgBISAEBACQkAIpBYBEZ3ULq0mJgSEgBAQAkJACIjo6B0QAkJACAgBISAEUouAiE5ql1YTEwJCQAgIASEgBER09A4IASEgBISAEBACqUVARCe1S6uJCQEhIASEgBAQAiI6egeEgBAQAkJACAiB1CIgopPapdXEhIAQEAJCQAgIAREdvQNCQAgIASEgBIRAahEQ0Unt0mpiQkAICAEhIASEgIiO3gEhIASEgBAQAkIgtQiI6KR2aTUxISAEhIAQEAJCQERH74AQEAJCQAgIASGQWgREdFK7tJqYEBACQkAICAEhIKKjd0AICAEhIASEgBBILQIiOqldWk1MCAgBISAEhIAQENHROyAEhIAQEAJCQAikFgERndQurSYmBISAEBACQkAIiOjoHRACQkAICAEhIARSi4CITmqXVhMTAkJACAgBISAERHT0DggBISAEhIAQEAKpRUBEJ7VLq4kJASEgBISAEBACIjp6B4SAEBACQkAICIHUIiCik9ql1cSEgBAQAkJACAgBER29A0JACAgBISAEhEBqERDRSe3SamJCQAgIASEgBISAiI7eASEgBISAEBACQiC1CIjopHZpNTEhIASEgBAQAkJAREfvgBAQAkJACAgBIZBaBER0Uru0mpgQEAJCQAgIASEgoqN3QAgIASEgBISAEEgtAiI6qV1aTUwICAEhUB4EfvzxR3PTTTeZpUuXmgYNGpiDDjrIrLDCCuV5uJ4iBPIgIKKjV0QIVAiB5557zjzwwANmr732Mttvv32FRqHHCoHgCHz++edm2rRp5umnnzZvvPGGmTt3rvnoo4/qvMHGG29s1l9/fbPjjjuaevXqmU033dT06tUr+AN1pRCIAAERnQhA1C2EQCEIrLXWWubrr782G264oXn77bfN73//+0JuUxWfeeutt8y4cePMyiuvbFZbbTWzxhprmNVXX93+984772waNWpUFTiUapI//PCDmTp1qvn+++/Nvffea7766ivzzTffmHfffddi/t1335mPP/44ksfznrdo0cJsueWWplmzZqZnz572v2VCoFQIiOiUClndVwjkQADX/uTJk2uueOGFF8x2221X1ZjhLZgxY4aZN2+e+e9//2tefvll89prr9lwSC773e9+Z3799VdLfDp37mw3Z4jPn//8Z/PJJ5/Yj7KRc1379u0tufzpp5/s5r3uuuuaI444wqy66qpVg/2XX35pJk6caJ566inz0EMPmU8//bTic2/Xrp3p0qWLOf74463nRyYEokRARCdKNHUvIRAAATb0TTbZxG64GF/sbkMO8PHUXLJs2TJzxx13mNNPP90sWLAg57zwenH6z2Z4HmbPnh0JLn/84x8NRKBjx4425AJh2myzzczf//73RG/AH374obn99tvNzTffbN58803z7bffBsYL7wtYYJDONm3amG7dullyuPnmmxvCU7798ssvhrAsuh3+hGT+5z//sV4i1om/h2hmM4jos88+a0mpTAhEhYCITlRI6j5CICACZ511ljnzzDNrrt5mm23Miy++GPDTyb8MXdLFF19spk+fvtxk0HDwwwm/efPmNf+NtyaIvf7661YzwmaLlwwShEGqnnzySev5wQjRPP/880FuWeuaxo0bW5K66667mrZt21qPEPqTuG3MEIkHH3zQ/Otf/zKPPfaYWbRoUda5/uEPfzDbbrut9YZ16NDBhpQ22GADKyTGI0bYKmr7+eef7fsO/oRsWSc8eM6zNHToUDNq1KioH6v7VTECIjpVvPiaevkR4Au9VatWtR78l7/8xW5GaTaIx1VXXWU3MF/rgZfmqKOOsmE7tDal2FiD4EqI7IMPPjBswoR0IESs1TvvvGNmzZqV8xYrrriiadmypalfv74Nv0CEIAvlJkB4xdAyjRkzxoYAs2lqmjZtagkaY+MHkh2H7KglS5aYI4880tx1110W62uuucb069cvyNLpGiGQFwERnbwQ6QIhEA0CeBVwzWeGWfDunHHGGdE8JIZ3IUzSo0cPc88999jREapDF3PcccfZ0EcSDC/RK6+8Yp555hkbZiQU8/7779swUC5bZZVVrMeEcA/hnyZNmphDDjnErL322kVPG/I4f/58Oy7eH8bCO+YbnrE//elPplOnTtZDttVWWxX93FLdgLnsu+++llxi119/vTnmmGNK9Tjdt4oQENGposXWVCuLwGWXXWYGDRq03CA4haMDSaOhQ9pll11sqGKllVYyw4cPN8OGDUtNhhl6E8jPE088YdDBIKTGIxTEdthhB0v6KC+w//77Wy9QEHvkkUfM448/bu68805LcnyDUOGpwUNGGnfSMvkOP/xwc8stt9gpHXDAAbUE+0Gw0TVCIBsCIjp6L4RAGRBgIyRElWkUV2ODTKMRBmKznTRpkp0eG/r9998fOz1L1Nij/4H8IKpFM0QIDA9QprfFfy4kEM8LxAQh9IEHHmjDShg6owkTJphHH33Uam58Q1uDh+jQQw+1HpuGDRtGPZ2y3e/WW281hx12mH0e4nPCuUo7Lxv8qX6QiE6ql1eTiwMCuOLZvLIJQvHwXHLJJXEYZuRjIDxFlg/GBnbDDTdYr041GqSPkCUECC3NnDlzLPnJlf0EaUEsTGE+3xAM4yWjRAGi6DhobIpdUzxjG220kfnss89sijlidcJ+MiEQBQIiOlGgqHsIgToQQEfRtWtX68nASMX1CQ9hCPQTaTNfdI0eBf2FivrVXmUEz4S68PzwJx4bagdlM1craJ111jH8QIL4Ey8Zqd5J9uQw39NOO82MHDnSEuLx48engryl7Xc6yfMR0Uny6mnssUeATBJ6AJGZg+j4vPPOs6nNzqjZEoUwNW5A4KlCk4RJVBpsda677jq74ePVwMhAq6veTOYd99tvP+s1xMuD4DlJdtttt1lxOnqll156qaZmT5LmoLHGGwERnXivj0aXYAQohHfuuefaGeyzzz5WiOx7b8iAwdORRnN1ZUi1plaKLDsCePwgOGeffXZNOjiEhdTq7t272wwvqhffd999ZuHChfYmeIByGfVwyHLr06ePrY8TV6OCNVlV1PuB1CGuJutKJgSiRkBEJ2pEdb/UIEBmSzYBcZAJojH4xz/+YS8ltEAmCaLco48+uubjf/vb32y12rQZuKEdwSg6RwNI2fIIUCiP9wG9DgbBGTFihNltt93yhm6++OILSwzQ+UB8uEc2sTPFF/EqkuFFNlalW10QrqNQ5KWXXmoz1WjDAeG/+uqrC/5d07slBPIhIKKTDyH9e1UhsHjxYjN27NhalYs5bVL/BqKCYDKfUQDvxhtvtJdREI8miRRqO/bYY20xN2dpLYrGRrb77rvXzBMhLqE72f8QoJAfdW/w5GCQkIEDB9pMq0IrLOPtQdtCraK6qmwjBIdc8yyKBpbbXn31VdtKw40PzRbhXIhYGgTV5cZTzwuOgIhOcKx0ZYoRQCvz8MMPm5NOOslAdrLZnnvuaf75z38auo7XZVdeeaU58cQT7T9TKI57rrfeevb/8W74YQcycAgzpM0oXAexc4b4WkLk/xEcdEtUiCbbCjExAly8OlFmo0F60IVNmzatzjYXFGokNAbpKUcTTfpc8f4jtsazNHjwYMPvU5xDa2n7vazm+YjoVPPqa+41CAwZMsRcdNFFeRHJFW5ymSPchCwYyvD7lX/XXHPNmt5LnNwppkf6cNqMRo4+gWOTY+7Vauhw6BZ+wQUX2Jo6q622mhkwYIA59dRTDU1ES2lowAhvERJzFYf959G2AqKFlqxQb1K+8dPUE28VmYe9e/c248aNK9mz8o1F/16dCIjoVOe6a9YZCOCByFfO333klFNOMeeff36tO6AxoP4Hhnv+wgsvrBXmQnjpZ8OkWYgMwaPOizM2uqRV6I3qFwRiQ0YU1a8xKiCz0dMMtJyGNgZNEO8pIVjq1viG95FO8nV1iC9mrFQ4pocVhIpwncJUxaCpzxaCgIhOIajpM6lBgEqzVJb1De/D3XffbcWRuNfJevFtjTXWsCnArqAZ4SzCABhhq8svv3w5fOjYTcNHZ6TToqlIo1EYjyq/zuhK7cJ3aZxvtjnhxUF/AuFdunSprfTLZr/99ttXHALCR5Q5mDJlSq2ChYTSCHdFNUZS48keg9jtvffeZurUqZGG6CoOpAaQGAREdBKzVBpo1AigZSArxTfIDUJRl22FN4Ly+v/+979rXQf52WOPPawGh5RYBLeQHLJJshnCY8IVztDyOA9Q1POq9P3QOPmi7blz55rWrVtXelhlez7hIt4ZMqEgDxAe1rpUoaFCJ4ZeDMJN53ZnkHc8csWSHX5vSHGHTJGBB8lLY72oQrHX58qLgIhOefHW02KCAN6Uvn371nLh11XYjhRYKrbi5XEF3BCVbr311rY+DmEAQlknn3xynZsZqeaknDsjBdsP78QElsiGQYNKOn5jo0ePtp3Kq8F4B1xLDzZ45h7nfk1LliyxRQap0O2MsBqZgoiHCzFIDnOHSBGqI4ux2jx6heCmz5QOARGd0mGrO8cQAdz2aAUya7twCkc3U5eRAkyWlLMTTjjB1jF5//33zahRowxi5lwndsJjfkNG6qCUWohaSfh79uxpBbgYbQoIiaTZ8FpRVgAdDN4sikWSNp2Efk0QdTyYfkYgguknn3zSdkEPYzSoxcNJ+PLggw+2YatcWYph7q1rhUChCIjoFIqcPpcoBNBJED7w69gwAU6abMLt2rXLOR/q6MyaNavmGjYCWjlQ2RWBZb6wBCm1jlzh7fjggw8ShV/YwUJyIDsY4lM8YWkUoeIRYf0hNswRLwheHLx9STLeZUKxTz31VM2wWS9q3rRp0ybQVKgdNWzYMCs8P+ussyzRkwmBOCAgohOHVdAYSoYA9XHQw5DaSwjK2c4772wrFwctOb/ZZpst18rg8MMPt255CgrmM5p5vvfee/YyRMmuyWe+zyX13/2mnswBb0Gxuo+4YUFXcUKX/MnmjmcPT19SiyPincQrRUsGZ4iIaT+RyxCbUxeH6t+sMZ7OpDcZjdu7pvEUh4CITnH46dMxRQAXOhlThKoQCjtr0aKFrV+CUDLohkRF11atWhkyaZzxRU4PpyChCT5HvRyX0kvGCyfftBspy669AaSSDKS0GFl0lBEgBEn6ODWY/CKJSZ0nns+WLVvWpMMzD9LRMzMT3fzwAFEjBxzINkT3JhMCcUNARCduK6LxFIUAHhzEoFSfJazgDI8Kglgyo8IW6eO0mplNRWgGshTEIF2kFzsjHR39QtoNTwAYURiRjBtwqHSvpSgw94tLEg7l3YiysnEUYyzmHs8//7ztt0X1ZoxyC6+//roh5OqMw8M555xjm5FyLUJ7iK1MCMQRARGdOK6KxlQQAjfffLN1oVPjxhnC0BtuuMF2DS9kM+ILHR0P1X2dEbKixH5QY+PwwzaEOrbYYougH0/sdRRJJK3cYTd06FAb3kmyucKQpI0TqiF0lU+flcT5ojmiWrIzepdRSgHDe8P/E55MerguiWujMYdHQEQnPGb6RMwQIIyAt8YvcU8YAVEoaa7FiGDZzCA2zvAGUVI/TAXZ2267zfTq1cveArLFSTlIyCtmMBc0HGoHUUPIGV4edB9JNAS21MRBj8M7V2hn+yTMnXArgmrIjDNqRzF3UsYJ+xLScl3qkzAnjbF6ERDRqd61T/zMKXTGydNP227cuLGtZwPxCSISzgUCmShocQiHOQsizsy8J6ENPE0YBQoXLFiQeOyDToBGlmScufYaEEWKL5JyniRDf0IDTHpDIbbdaaedkjT8gsZK2woqXLv3n8MD3ki8o2CgtPGCYNWHKoCAiE4FQNcji0cgswmna5QIoWjQoEHRD0BXwmZGfRRndOBGXxO2kBrVZwmrYZ07d66V1VL0QBNwA+qxkLrsxNh4BahJlBRNB7VgXMHDyZMnW/FxtRgeLDxZzkgZB49ivKTVgp3mGR8ERHTisxYaSQAEqOtBZgcdsp117drVCiOD1vvI9xhCS5xa/WfwGVz2hKEgVWGMTd5VniV9l42i2gyBOJ42Z6uvvrrtt4Q4PM5GuIbsPUKNkFW611eTsW5kzNEUFKNWjurjVNMbkI65iuikYx1TPwvc52R3vPTSS2bZsmV2vmSB0HoB/UvQVPF8QCE+JjzlhJfuesJguPLJ3gprpOu+8sor9mMQstNOOy3sLRJ/PRslwt3MCsloeK644opYegjQYhF2o6UBBJd08moximNCctDh4IFz3riwQvxqwUvzjDcCIjrxXh+NzhibNUXdmU8++cTigducxptoJkh9jdKydSvnND99+vSCdRnrr79+zdir+UQMQaV4I2Tv888/r1m2v/71r+bWW2+NVdNHPIdkylHtmPAN71s1GBlVrBG93NAjUfvojjvusCFbbJtttrHVkmVCIEkIiOgkabWqbKx4b0hx9TuHU4+GhoNt27aNHA2q2lJ/xzcqKPNF79fBCftgvEGuaCFVZ9HpVLM9+uijtpEkm6ozdFXoYEhBr3StHUgYGUdUsqZyNs1c05hCnvkOXnvttbaYJpmBaN369+9vBceQPOrlYHh3KBdQLVmD1fx7mqa5i+ikaTVTMpfFixdb/Yaflky2Dl+2aDqiClP5cHFfTrK+USuEdOhiv9T9TZKmj2EbJaZkWWtNA5E3mVeZPb+aNGliC/AdcMABFZs2lX7JKiJ9HE9e2oW3EHn0R6TMky5OmM4n9lOmTLH6NGcLFy40rJNMCCQFARGdpKxUlYyT2jfDhw+vOe2zyVB+nl5VpI6XwgiBkT7sG5swnqNiSRXaFIiS8+iQWk6KuczYzu947NhYyXLzjYrDENtyd3gfOXKk1VBRJJL2BltuuWVqlwrCQlNa9GjME00OOqpMmzlzpunYsWPNXz/++ONml112SS0umlj6EBDRSd+aJnJGM2bMMGwyZLk4Q/iLMJisj80337wk80L/06dPn1r3rlevnhUP82exRuE1Qlcua4VwTbk372LnUOrPI/pFUO4E2+55aJvQhpRrU8VzQUgN3dddd92V2oKAaGyoaEz9Kd5FSjXk6r0GsfELAz722GOpxabU77ruXxkERHQqg7ue6iHQu3dvM378+DoxQTNAW4eoC5SRUcIG6zf9xGsE2YrqJM+9/cKFEJ+0h0IKfblJ5ydshKfHN4go4tg11lij0Fvn/dxHH31k1/ybb76xDTrx8qXNZs+ebYXVeCqxQYMGWY9avnIJFHv0G5bSzHaTTTZJGzyaT4oRENFJ8eLGfWqcKClG5peZr2vMCJOjqpPDM/AioMHwQyZspOh0oqwTAtEhdIVHByHnd999J6KT48WEaBBGJFTJfzuDhECGwxZrDPo7QOYXBABtEEUB02R4cBAU33PPPXZapMlTliFoqQQE9H4la+edTBNGmku6ERDRSff6xnJ2aB/IsJk/f36g8ZHmSiuBqAzvECdUP+uHe3O6RR8UpdFGguJ4GHof0pWrIYOnWAwRbSOAJfPJGY000e6wRsUKxP3xPf3007ZeDvekS3dahLaUMoAwMieMYocQnubNm4daHtaBsB6GpwuxuEwIJAkBEZ0krVbCx4ruAb0NhffqMjYb6pfgaZkzZ469DDc57vIojNARX/h+yjr3RZtBZ+oo2kf446TYnAsNQHiouiwLhgDeLzwPhJLA0bfrrrvOHHvsscFulOcql2XVrVs3q81JshGCAzMnrueQ0KNHD6vBocBmIeYT82effdb+fsqEQJIQENFJ0moldKxUWWVTyldoDNEpGS+ktrZq1apmtlEWbPNrgrgHEBa5//77zWabbRY5wlR0xhOBUR8GD48sHALPP/+8bftBuNE3iteNHTvWNp4s1BBAU7kaHRihVMhOEg3iB0lzYv4OHToYtG89e/as8SgWMi90PQ5fQl3vvvtuIbfRZ4RARREQ0ako/Ol+OKdwivCxGeUyvDhodSgWh5Fh5Tp8U3OGMEYU5jpQ+/fC20Ifqh122CGKRyx3D07Y7iQddQiuJAOO6U2pik27COoa+V4xhN5UVe7evXtBIyedGpKL14K1Yo2SYnQSHzFihC1o6X5v8E6hMQsbnqprzqT+I9jHojxwJAVjjTMdCIjopGMdYzcLanPQFyezIJw/UMTFkBvCRi4zCd1O69atay5DQEl12mIts4M292NzQ2hJ081SGSE35ylq2LDhchlFpXpuWu8LAUYwfv3119cKZ1EDhiyiMOYXwsMDQkf1uBtF/UjvHjNmjMFbiID+4IMPNjS2LYU3ihpWeLowpZXH/e3Q+OpCQERH70akCHAq5suRujjZjNRqToiISrOFHDJrdkSR4UGlZZ7lky6EwbR7ICRSSkNE7XQ/FAp0nqpSPrMa7g0hppo17SScoUWBAARJQ1+0aJFp0aKF9Q4RUiSsGpUXJEr8yTxDFwPBgcw5g/wfddRRNnOwVHWZyEIjGw0jDEbNKZkQSCICIjpJXLUYjhlCwkkbjY2fFuwPFc8NmU25atT4RCeKUM+SJUtsaiybhW877bSTwctTavv0009rwiEiOtGizXt26KGH1mQEcfdmzZpZkp1PVE5456abbrKZVnh2unTpEu3gCrwb1YrnzZtnf/hdcZouWqC0a9fOpr9D6KIoZplviGQmUkMHkwg5H1r69zgjIKIT59VJyNjQOPTr18+88847y42Y8BDeG9LJOUHnM7Q6aAGwYjUBNB9s3769ee2112o9llASwta1114733CK/nc2Y9dhXWLOouFc7gZodygoSONNZ3hmJk6caLbddtusD/zxxx8t+SSzD5E8Qt5KGrojSDdaNEovuAwztGqEpQjxQm7KaYTBpk6dah9Jzzl+v2VCIKkIiOgkdeViMG4qC7PJ1OXBYaNBzBiE4DCdDz/80GyxxRY1YtNiNAGEjBCo4iHyDeIFMfMLoJUSyqVLl9pCgRg6JP5fFi0CeM0ogocuzBmZbhSizNZ1nixACDCZVmjAyvUuuLG9+uqrZsKECTZDirE4I4SG1xO9EA1lo6rOHRZtfq8pwYBFmQwQdhy6XghEhYCITlRIZrkPmyweClKaiaWnxUhjPfnkk+vUm1D3hhN12Cq2aGbI0sJoNojgtBB7+eWXbXNCwgC+EaY45ZRTbLPIchp6oGXLllnxM94EvyVEOceR9mdRP8bv2YS+xPf0uPnTP8tlaSFG79y5c8mhoVv7tddea7PG/CKIEK4999zT7LbbbrH4jiBURZ2czz//3Ho8KQ6IPkcmBJKMgIhOiVaPgnS4nZ3hCobwUPsjqUY9E06cCDmzGRv4fvvtZ7U62U7SueZNGAHBsKviihuf02RYo8ggQs3Mfknch9Tb22+/vexEgzWnhQVGSjBeK1lpEKAaMCJl52XM1pfp1FNPtU0tMUKYdYW4ih0hBSgJSUGsfOP95F2EjMcpnR1ys/POO1tP2LrrrmtJIhWjZUIg6QiI6JRoBfFmZApgeRQbrXMLl+jRkd8WoTEVjfG41BV6IfODrAzKxRfS4gAC5XoMoWlBXxPWwJtU8WyhtI4dO9r7V2JjcbVamA/hilKms4fFLG3X864SKnW6rNGjR1t9mG/UNSI7EIMQk/YfhbG2hFs55DgRr7svXiPCa4iJnWYrimdGdQ8aqqJXgpBTQBGvLcJumRBIAwIiOiVYRb4s2rZta8MVmUaBOkrbJ8XoCwUxo6heXYaegAyWjTbaqKBp8VnXSBOSxEbBhhDGqHDrWkdkfg4Sxsnar7Yc5t7FXssGQtozxgZSinonxY4xTZ/fe++9zbRp0+yUCA2xiftG+jlp5bxrVPpt1KhRQdOnRxYp2HiNXNE+dyPuSWYfImJq3MTV8KDiASN9HSPEThZaOYT6ccVE40ofAiI6JVhT6sQgwsUQPNLB2jc8I1R5jbvRk4pNw4WTMse73nrr2arHbNyFeHG4H25yskocKaR6MV+8YYxTOSdmtDnOGA+ne/pLIa6MouhgmDH51x522GG2ei+GCJWy/LLSIcD7Q/jUGbWLSO13RgiZ0BUNVs855xxbEiGX8X5xDzw2EH88h9namey66642dEuVbVLB42z0D0O87QTcZCKCG8kFrgltnMevsQmBMAiI6IRBK+C1a621lk1dxfAm4K247LLLaj7NaYmqpnE20lw53WWSNDdmhJ4IFYvRm7CBEOJzmh8KoBFqCCPWJZRGjyw/TOhIDmM977zzaglUK4E5WT2IXjF5dEq/AoSqfCE7mzleR2cQdwgJ2U+NGzderiwCn8UDiKcGrw1e2MweZYTH0LNAoDp16lRUv63SI/K/J9x88802SYAaPa54Jr+/JBbwHRVlR/hyzUnPEQJBEBDRCYJSiGv4EvXTQvHcDB48uNaJkttRDGz48OEh7ly+S/E+4IXIZnhx+GLk9Oe6chcyMk7IZJs4LQOeI0hAmC9bNh/CAnWF1SAYhBbIeqqksSmyqWJk4kHMZKVDAO+e81TwPiGypeCeb0cffbRBuIwnEf0ZhxNCqGh3fI02J0rQAAAgAElEQVQXQnIOJgiWt95665o/Szf6aO/MHGnh4EJT3J058cNhpVBNXbSj1N2EQGkRENGJGF82XV9s2r9/f0P2BeTHDwEVkz4d8ZBr3Y6U7K222iqrjohCbNSg8cMAhYwFPQ2bkUuz5UuXDA8K6gW1X375xbrZ2ZyyGZ40nuMaaga9b9TX4RGDEDrPGKfpSmmFop5bHO9HuJKMIecx5XfRdfR24+Vdw2sDGSJ85RskFE8mxAavTxINUoPnxoVLmQO/s4ihORigW5IJgWpCQEQn4tUmROEXIEMPQIVf4vd+8Tq+TMnQiJNRZA8C4lKh/bExJ0TCmSfjsOPHkwUeEBUMwSb3zVeyP/M5F154oa2Jk83IaqEHUrZeWmHHW+z1hOd8sSs6oqAFFIt9djV+3u+2zfxHjhxp34M777zTZt1RXDCboaVDW4cHpFC9WSXxxguF54ZaQu5AhdYGIfwRRxxhdXAyIVCtCIjoRLzyfjEybn3FFVfYInhxJzp4V0jBziyyxxxIG6cTeTEhIDYYTsu+YBjXOeJcwgZhDD0ORJHie5nGaR4vj2tGGOa+pbiWthgUUHRGqI7S/rLoEaAoH4X3EAw7w6NHxW3f8Fji6eFaxMh+dWI8OZDkUjXKjHLWHBYoV0ELCzR1znj38XZyOAkTCo5ybLqXEIgTAiI6Ea+GX92XW+MiJ0zl93Di7+Pk0UHDAAmhI7RvpOHiAi+WNBCuoU6OO2kiNh46dKj1yIT1ECEQRQTqV5d1Y6aEPsSJYmxxMeq5+F2x0epUqrR/XDApxTjQjREizkZ+IS1kBnLY4D1v0qRJzRB4J0eMGGEz85whLsb7E8cUa3p70baCPlR+1WfINB4pvDci0qV4w3TPJCMgohPx6hEH55TljNRVTo3UeKGysLNyN8rj9EdtEbQLEBpOsVQvpvtz3759bYaJb6TIEuMn7bQYI/0coueMsBIudoTIYY0iguDohL3+59HBXHDBBbaBaJzMrxHEuAqt+BynOcVhLOhuEK/jfYH0ZtamotcVnlRIb+vWrXMOmd8N2hzccsstNddRjoD3FPJcSUNwz+8r4V00RX5aOxlj1Js65JBDQrdbqeSc9GwhUG4ERHQiRpwvHr6AnUF6IBSZva748sKFXirDfU/YDJIV1mi9QAiuGJLD5jFo0KBa9UwoPDhu3LjQXhw3flJgs4mPV1hhBVu3qJCK0xA8wml4lhCyLlmyxNZMIW39iy++sD9oNggBsBFCtngep31IGxsiYRAIJBtqZtuKTE8ezwhjZAVxgn/iiSesB6wuLVOm/ivMM5JyLfo3PC/jx4/POWSKdYIXHsmgxrrgFaJkgjNq4ZC1t/766we9TSTX4QHFE8y7znvHO4jxjuLNJOSGlk66m0jg1k2qAAERnYgXmS8fvqic8YWLuNc1q+Tv8fq4goJRPh5BIl4bhJcQlWyVmfM9D88IVXxxgxdqFAFkvpy2MYgBhAviU+gJmVAC4a9MY7yEHgiF5TJc/oQVWYtsjR4LnWscP8dGT/iCsgZ4wJJq1HrBq0g/Kj+05OZDKIqwlH+wgGiiV3Ed48PMHbIzZMgQW/PKieUhO1Q9Lob0Bx0DHl8af/LdQJYeJAdSwxryA6FGNC0TAkIgHAIiOuHwynk1X06cIn2dACnOhFR8T0QpUoxJKUWAmK2ZZdgpEu8nq8lvShr0Hrj7KfznCibi9UDnU0xlYjRETZs2tfVQfINA4e2gBk82o8w/mxSZNBR+qzYjtIEGpZBNvxJYQS4gNawZf/peKsZDOIq6L126dLEeUsiv38cK4TEkpxhSAtkhM5DKwe4dphwAZKqY4pi58GS+PI85Yx06dLBFLuPcOqIS74eeKQQKRUBEp1DksnyO7I7Mrt1sNGzErjAeBffqSnEtZCjTp0+3uhQIVS4j1ZQ0W2rWkJmE12bx4sX2IxAGGhv6Al8IG+nmQYsCcvrGY+P3/EGHgxapWHEkxAmy4hubOGX+s9U6IWyHJ+CSSy7JKlquCydIGevji1XdtZyofSx4PtfjvXLGcyFX/BvPJwTmDE9W9+7da2VgZRsHZO6HH34I1GgSoTPvFeE0vIS8e6QT+5YETRBZdHgxqEGVqb8Cd7KHEMT7YUE8hHjynOHpwOsTtkdatjXgoEImE6FCd2ghVImXlJBRFIaHkSrgjJnQKRmN6OXwwqnOUhQI6x5C4P8RENGJ8G1g08v8kiJ8g/vZGZtdZgPAQobAaRc3Nx6UbIZXhvCRq4LKadg3iA3kBP0J92CDJ6Tjt6pApMwz8hmfpzaOSx3nnoSSTj/99MBEqa5nUAclWy+ibBonStzT8qGu3lzuGehcWBOwITTB/9OxOQqDWFDLxHVid/cEH2oqldp4LwjplPu5QeeFx4TwIV7NOXPm2HBiZtE+stQ4HFCxOLPg48yZM21mEX3YnEHUed/wxERZAwctEIcIyCvGc8js4veiEENYzDvKPRxB3nHHHW37BbxUUXVRL2Rs+owQSDMCIjoRru4bb7xhmjVrVuuOnLD9vjuIcfFQFGNkWdRFcEiNRVRJb59c8Xw2RDYZxuefUhHU+mnmVELmSzibcdqFuJHq6qx+/fo2VOX3Fip0rtlCgWx8CLyduJtNEnLje6iyPY9NBLEymwoi8Cg3RJ6H94Z1mT179nKPJwSIN6Bc5tdsikMZAwTehJTY5NGQuZCQjwe1lNj0Cb8S5sys/4L3ioaveFp84x2HjNPSoRRGyBnPDt5NZ7Q/gewEKROAx5X3lfk7b9VGG21k50jV9HwZYaWYk+4pBKoNARGdCFecsAOeEd8IJzjPCRkTnPQzrwkzhLpIDu0T8BqwkReziWd6BAgZZBPvQoYgDu5kSm0chJycrMNku+SaO32H/BM9mwLhKjZv9BxkQZHVRFG+usgNhQ4hGnhvisHF3R8ig+ibsUFu3n33XRtygeRmMzZwQoKEucphvIP0ZHJhyEoQHbwuaFrQnDz33HPLNcT0cSCc6ggoIVVnhOOcVgeSkFnjiesgRrzzUZDqXGvDO05okIKEzgg1oasZOHBgrY/i/eF3nHRw9GPOKERIQU7mSiNbmRAQAuVDQEQnQqzZfNFxZLrieQSeDkgAOpZCjRNt5hcrmzjkhlYKUW2m+VKiMzOg2MzxMEWlX/Dx4eSMfgPPESdrBKFUasaL42tg3GfQIvXo0cNmqeAdKJTc4K1C40OlaEgMmx26iqCGZ+/ss8+2dVzKlSlDlh0F8SAazspRrwkSQrdvwrSkgGfz2Pi4QVhpGguJ9r0iECM8c9TIyazr5H/ekfpiq3UHXUuu431wImU/2QCSRbj3vvvus94qsiwxDjiERckUhJAVI5AOM05dKwSEwPIIiOhE/FY47UvmbelvRGYUQtVCjewZ6rs4IxxSSGZUvudnenXoyYVngM2Hjut+QUS+zCEiZEWV2vDc4NHyCy+6Z6LrgPARtkNLEdTwzJCO7zwG6EfQGrnaJUHv465DtMomTqZdUCF32GfUdf2pp55qRo0aVfPP1H9hflEb5I/idRBeRPB4tXIZYSjeU3RRZBSxjtwDzx/ZcIji8X7kqzHE+w+Zpghl2N5oUWAAkYSEoRvzySRkmrFDrhHg77PPPmqcGQXguocQiAgBEZ2IgHS3wS1NFkmmsQHlq/WSayiZXhaExhQELIUh9PRTadHcsDFxonUVaPlyR6hJGno50pcRcEKyCGk4g0hQWwRyQ1ggiKH7ISOK0AohJwSihRihCzY+NjhIHkSWDDA8OJVoHYD2K1OnMmDAAKvDCmtgROiFLDKIDFlgiIfxaOXytLjn4FlEJ4QnC3z5f4hMWKwJZeH1gdziBQrT3T7snPNdj7eJd58CgryLTqDsfw7RPGnheBVlQkAIxAcBEZ2I14IQkt9gz92e0u3oRAoxNhgEtC50wsmRk2XYZphhno02xnkDyNjyPRx4CiALpQhVZRsjmweZTM6oEIuQk1CWr+tw/w75wHuGkJoNCeKZL/2+LmzwwEH6ILCsH0JSvBKFhsTCrEHQa/GsEK7zQ6b16tWz2WeZ2XbunuhNCDNREgEvFu+Wr0EJ+myuAws6tLPB470h5T0sqXHPA2PIDQSWNiTFNJINMweuhdiBGe8L4md+ZzO9h/zO4Z3ih/cCgTUeHleck3GTfLDpppuGfbyuFwJCoEQIiOhEDCzeBbQdvuGyJ/uiUMv05pQqZOWPDy8OGghO976hlUGEWY7TNVoINDp+yX/SwCFZVP91hgAXjQRhEITffhZYLszZoPHE4BmCtLFJ84NwlE0bQlloJedC1zrM5wgxEvbJXCfmg3cJQTK6MXCEqAbxxgR9vgvXBL0ezRKhKsKKrpErOhY0OpAZBNRoWYoR6gcdC9fhmSGTCnJH3zc8NniufCN5ALLFuwDR5d3g7zINsT6hSleUkncGrRF1cWRCQAhUHgERnYjXAA0NOh1Oh86K8eZwj0yi4zQzEQ/d3g5vCEQCvYvfQoKif7jsKd5WLstshMpmiP4FI5uHjQlBMkLhfPoOPkOIDQLAHCBMSW6P0LNnT5vGH0eDwEBE+SGkiJez3HolHxc62hOO5Z1Bf5WZpQeZoXULIUjGTJgsLOEihZ7Udz88ze8Mh55sRS3juG4akxBIKwIiOhGvLBoSivX5oR7+m548hRpfnpwYnXGCxL0ftaGjQOeRTcDKl3hm1d2on595PwSnfv2SIM8jzZ0KumysbGB4Dwg1UciRzLekGyEhdFFUBnb9mMo9J7Q3DluIAQSSkBPhMrDPrIFT6vEhJIe8gAfhOLxGiKUXLVpUq6s57xMePLwzjJ/wLOntURrkm99VDgWuAjrhT7IlqZ8VVWZklGPWvYRA2hEQ0Yl4hdmE0I74Rty/mKykUoauCGugMyAVOrNPFimxLoWbImmkt5fT2LTQ4qAf8UXIbgycmNGGMAdCChQ2ZKNN42bCJs460dspW/kCMCFkgn4qVxaU09FwPThBCiCF/OCJBD9ff0QokDAlXhn+PbMgZqneB2oV4X1xdYsgVwiiGQ/zRweUq34Sv2/oqRgvxAY9TTlTvPHw0Akdj44TLuPdojo2RT1lQkAIlA8BEZ0IseYLDbc9dUR8DQOny2KKmlGdlVCSM7QWeI2KMTYQtCx4BjKNzZKsG/QLZO5gbHTUSqmEsclTowWRNyEGBMh4Ekopxq7EPLM9k3eJyr/UasnmaYOYQH4QIzvtC9ocSCveH/RGlcgCC4ofxIU6ReiNCPEyZsTAEAUM75ArqQCZdSSM0JKrKuxIDSSuffv2QR9dluuYB2J6+lo543eJLEz+lAkBIVB6BER0IsSY9Gv6O2Fsws4LQcZQppcnzGMRNvpho0IbNVLMDBEmdXCydTknvMYptFevXoYQ0IwZM2wBOgxvQaGZNGHmqmv/hwCkBpIJ4cw0Nn80RmyehOWSYJBmShRAZggpoZmB3EDOnMeDTCXCPGQY8kO4MZv4NwnzzRwj2W2I+Pn9coZ2BxKUZK1YEtdCY64+BER0IlpzTqa4yXG5QxIgJpSwJ05PMbtC05sZXmboKoyHiDYJFPTjZIkYM5uR+YJXgOwdPx2Zz/D/TuhLqKCYgocRQZ3a24AzmyFp8a7Crj9ZvBhoqHr37l1UKLRUAEKiyQLDW0i2HpmGhJz8Bpw829fK8D7x+1GIALhU8yjlfSGweFGpWO2MlHSKIDZp0qSUj9a9hUDVIiCiE9HSn3TSSTUF/DiFQnLovoz3hOylYjKlMkNXVCkm1u8aW2ZOgZMzJ0XaMuQSrEJwaElB2KMuXYuv1yhmDhHBnMrbULOF2iu0EHCNH/2Joo3Bu9OvX7+KhqEQ2lK/CQJMOjZeGohNtjEzftLFXWo2mzgambiH0sr1gqHboxSF3w+L30N+r4M0Cy3XOPUcIZAGBER0IlhF0ptxs2N8sVOxmD5LU6ZMsSSCDYIveghIIZbZqJF74GlBQMpGw+aBaxztCtfiXcpm1Cshy4QTZNeuXa3wNF+7BL8TtohOIatX92fQ3kBiqeOSzXinIDikkkfVKDXIDAhZ4oEk9MrYyHzL5mGCuCBUdhoZxkvmFaGYSqaTB5ljXK5B98ahxC8yyprTrDRsintc5qRxCIG4ISCiE8GKoJNwYaFu3brZ3kl4QtgoICR4dCAUxaQDZ4avwgybzsuko0NuwpanF9EJg3TuaxEWU/yQdg1kEGUzUrUhooSnWLOoG4LyTpLNxH3ZZNHH4F3AK5ONcBGOhcyQuYROiz/RcvkFG6NDqHrvhDePXmVz5syxIJAQQJsXCmZmq/5dvUhp5kIgPAIiOuExq/UJ6mXQ8wkj1ZnNw8+IIvbOiW3w4MH2z2IMouK7uvPdCzc4YyvmZCiikw/l3P8OgWDzorcWocRshQ0RF5OBs//++xtIaaEbG+n4eA/x7pHJRDgSLxzCeN7LL7/8crnBQqzIFITQQNhdRWhqDiEIlpUXAbzAHGoc4aHWD7/DaOgKfS/KOwM9TQjEDwERnSLWBHEuIkpO6giQzzvvPBt3L5UhZKQeCILnuowQB9kcNMCkOFqxhqiarC+s0GyvYseQtM8TooTgkiZNWnw2I8wDsYBI4sHJVcyQbDeqVeMRxBNEeJJnEKLEI+NX4c58lqs15KdjQ2B4HplbeA5k8UMArzA9tNBCYawTQnQ8PNQHkgkBIRAcARGd4FgtdyUFwGbOnGnDVGhyqB6cT/NSxOPsRwmD0WjQ78sDAaGzMhsmGhxIV1TG/ciiYVNEiyTLjgDp+jfeeKMt6peZZeQ2qn333dfiSBsLiAY6GFeQkZRrSAzF8Miq453CA+NX2M58MrovvIeQGcJLbIDoZfAQUflXlnwE8PBQc8dvLspBhu8avD0yISAE8iMgopMfo6xX0FiTBpcYwks2N0IAaTO0HHgS+LOuirxpm3OQ+VCtGW8NJJB08GwkkNAR5INwEOEjyBAhpSDmPDF46FybAoi1a4BZV1fyIPfWNclDgHeN0gMPPPBAzeDp2Ua1cmVpJW89NeLyIiCiUwDenMIJWeFFwXuCbmbPPfcs4E7x/whVdRGwUu+krpL78Z9F4SMkq42wEdoaBOesPS0WSLHO10iUd8ORQ0dcGInfSgEC6SrkUjyvXbt2hQ9Wn0w9Anj9rrrqKhsadUahRbw+7uCVehA0QSEQEgERnZCAsblRH+SZZ56xn6RWDv2t0mh4cvBGUIKfLBu8F2kwNC+EmSAZEBk8MohxyXxxDVizCXdzzZ3NhjASNZRcVlJaqvqmYc3TOIcrr7zSknBC1xjp/mRu0TxUJgSEwP8jIKIT8m1A5IvoGKMODXqKtIYREL26jC1aQVCyP+6Gx4UCfJx8CSfS8JPMI/7M1iuqkPlQK4ZwUufOna3eppistkKer88IAR8BDl033HCD/S7C28j7SG88hO577723wBICVY+AiE6IV4ANc7fddrOfQDtBZVhO8mm1l156yWyzzTZ2egcffLBBl1Qqo1EppfHJCOK59HgiwwxRLjhjeGDQuhAS4u8hHBAY/r7QFht4YfBYkcFUVygKDQQ44MlDJ7P11lvX6vBdKkx0XyEQFgHKGFCI8pFHHrEfpfYRrV0GDhwoLU9YMHV9ahAQ0Qm4lDQjZJMjnRfxMdWPSfdMs5FBdMQRR9gpkjaPGDKsUZwOPQt/EiaiBxJCXuqEoHGC1JTCICdkpbi0akgMISVS88lkYRyOQPnPJyuK1ho+uUEALBMCSUKAgwMHs7vvvtsKmDkQcHA45phjbLhdJgSqCQERnQCrTdE3XMB8eWC0dZgwYULJU8kDDK2kl1Cdl0q+2KRJk8whhxxS5/MIc+HxgTzgXYEY8uXqp8EXO1hCha4VgitoR7o9/404HD1R+/bt7WPw0lAkj7RcapFAtPjxjdYZ1LPBW0PFXz4rUlPsKunzcUOAOksUIaTvHk2GsQsuuMD079/fdo+XCYG0IyCik2eF0XvgycELgVGnhK7M1C1Js5EtRKVn+hxhfFlSmRUiAybUfYHEEGKC1BRrhKEIW1EbhnCgIzKuNky++yOU5gQ7f/58+5NNON2pUycrFsZjw5r6DUvz3V//LgSSjgDe6Ntuu82GtvCkklGJcJnGvnEqQkgFcX74zuXwlKuYZtLXROMvDwIiOjlwvuaaa8wpp5xiw1UYxQD5gnANPMuzRJV5CpVZDzzwQDtnhLeklocV87qmj8yAInZt2rSp8chAonClQ2ogN0EN7wzZUWSa4EUi5RvPUaYRsoLUQGict6bUxRyDzkHXCYFKI4C3E2+t89ii4yHhABFzJQ2C43uO+Q7u169fJYekZ6cAARGdOhbx+uuvt/1lnKHvmDhxounSpUsKlj33FAj7kLHx9NNPW69HNpEupIFQEuEiWk00aNCgpkIvpAZyEdZjgpaHzC7ExXjNIDA0nMRDQ/+mXAaJIgWeRpgQKP5fJgSEQG4E+L2ivAKhLH7X0KbRb42wVrmyCenRRrsUOrZnGjW8KLwpEwLFICCikwU9frmocoxYFkOfQwVSwlZpNkJSNBBE1wLpcAaRIY3aaVhoL5CrzQSeljfffLMmOwqiRKsMPkMTSX4Ie/EcdDNkUt13331W5E2Nm7qMQnusAZ4iChiS/UTWFFobmRAQAsUhQMYWoa3JkyfbG3FoOOmkk2oyTYu7e+1PExK/5JJLbFJHNo8sVxO2IttTJgSKRUBEJwuCnGaIY2OkFBPGqYbmh4gVOc2FMTw5fkirLg9Qvns6EgMZglDhFSJkhlgSMuN3hM93L/27EBAChSPA4YOQFv20yFIkE5HvRMJaHEaKMVqlUEbi3nvvrZEE+PfDE0yV+TPOOKOYx+izQqAWAiI6GS8EGhBCMs6eeOIJq/WoBnOelwMOOMBmZyBWRMCLEJnU8Fx9mggX+YJGCI8jKg47wl2QGGp7YJAYrgkb4qqGtdAchUClEcC7SokJKjC7OlWkp0N4OnToEGh4CIpnzJhhdXWUdeC7JNNIcjj77LNtuBxSJRMCUSMgouMhyi8lqcZs6oRXxo0bZ3r16hU15rG+H6etESNG2DHiVfn666/tnzIhIASqFwFq8dBjCz0Ptv3229sK8a6AKn+H9+emm26yGY+EwQh/1+XhJcuSpqQke1RDckf1vjnxmLmIjrcOhEdc40q8OIiP45R2WepXhpYJiBHpccUX1Lnnnmt758iEgBAQAiCA9o5EDX44BCEURs9I+NrX9WVDCy0dHuI99tjDem9y6fyEthCIEgERnd/QpDeSy9Rhk0eX061btyixjv296KL91FNP2XFSLJD+OTIhIASEABlZpH67oqD5EGnevLnNyCTp4LTTTrMeIJIIZEKgEgiI6PyG+pAhQ2paHJBlRRZQNRnhKsJWGF9Ijz76aKj6NtWEleYqBNKMAJ4adDWE8vHckPqdy8iapLGx84a3a9fOnHDCCVUX9k/zO5H0uYno/LaCuF9drRYq7FI9txqMthbokKiZ4+yee+4x++67bzVMX3MUAlWPAFXQITMkXpBeTgd0V1ojExxq6+Cd4TBIJXO84IiJMYgRn6fIHyEubNiwYaZv376pryRf9S9RzAEQ0THG1nLhlxbjF9n1g4n52hU9PL6U8OQsWLDA3ousqFtuucX07Nmz6HvrBkJACMQXAWpY0b6FTKhc2ZSE8fHQUM9m9913t8kaQYz7k8wxduxYWw2dqsukjHMvmRAoNwIiOsYYPBhdu3a12CM+5kST5nYBZJWRLUGBQGekfHMSQ5sjEwJCIH0I0L4GckM4yvXuyzZLvgtow8B3IsJhQlPF2GWXXWZuvfVW2xOPCvN0T+/evbutpC4TAuVAQETHmJrS5w5wUikpWpU2I5vq0ksvNaNGjTJffPFFzfQ4rV100UXS5KRtwTWfqkOA33FC7yuuuKIt7kf9G+rgEKLOlRVFzzmSESA3/JSipAShMQ6VpKBTTwd5wIABA0znzp3V5qHq3tTyTlhE5ze8EeDyZYDxC8iXRZqML7wePXrYpqTOSA2dNGlSVfTvStNaai5CwEfAHWBIJkBIHMQIJ5HiTTsXUr7LWbiTQoR4eNAFuaai++23nxUw+3V5gsxD1wiBIAiI6PyGEh1yR48eXYMZxbAQ0iXdIDb0lOGLxRnFEBEIMsdiS7onHR+NXwgkFYEXXnjB3HjjjfawQn+5fEaRPlq8oJfhp1xNO3ONi3FTfZl2E6SwEybj0Mn4+O8NNtjApqkT8oKckTBC2A0vdKNGjfJNWf8uBCwCIjq/vQjUhyBu7NugQYMsSUiSffnll1YAiMCamjiZQkN6d1HhVI0wk7SqGqsQ+B8ChJzpw3fxxRcbftdzGULi+vXr2wypQw891LZtgDRU0vA40Q6CnlcLFy60Xh0ITliDtEF6CNHJhEA+BER0fkOIDrqI495///1amCHKozownbLjZowZLxQ1bzjlcMJbtmyZ/fENYTUnpIEDB9q0cfWWittKajxCID8CZElCWOhJl83IHOXfSf+mp1wlSQ3fQc8884w9cD388MOGHoIffPBBnWnr+We//BVUY66GZsuFYKPP1EZARMfDY9GiReaoo44y06dPX44scHJAsAdp4AuFzISff/7Z0G0X9+vhhx9uaGzJLzQnLRpWQkSIR1MdlLoU/MmJhpg65c9pmsl9VlppJXtSo1cMJzD+m3tzHwSE1LngOtLAXZO8IC8yqZzocmjS2aRJkyAf0TVCQAjEEAEqteNx5nsh0zjEnHzyyRWpfcV4yOQik3PWrFk2Y3XOnDmREppsy9GnTx/ruZYJgSAIiOhkoLR06VJz3HHH1YjkgoAYl2vo1QUZO/roo23WmCvkFZfxaRxCQAiER+DYY481Y8aMqfVBvM8Qn8MOO8z2pyuHcYibPHmy9dDQFy+ILijfuLbbbjt7CGvdurXh+4sf3x5//HFLpAh1+cYhjuxRPO2EsWRCIBcCIjpZ0HH9WRDIffvtt7F8g3DZtm3b1uy///6mWYR8CroAAAi/SURBVLNmVnODh0gmBIRAOhB47733bD0bQkDOSPs+66yzzNChQ0s6ya+++so89NBDZubMmWbu3LlFZ6HiESeblYKDhNYgNLmKB+LNRk9I6Ms3PFdHHnmkGTlypCVceMNJJKH+V8OGDUuKiW6eXAREdHKsHUJeXMb8whNOwiVbV3w88zboYIJe26pVK5sBwZcLYarMbAhObLSowIi9N23a1P7IhIAQSCcCH3/8sSUF6FqcNWjQwNx11102XF4Ko4AoGVCzZ8+2ImG+j8KaC+1vvPHGBm8Naet8d4VJXyfMT1bV/fffX/N45oxnxyczHELxdPHz6quvWu/O4MGDzYEHHlhRfVJYzHR96REQ0QmBMQI74tDobjBSt/3Ce/wdOh0Kb/kuWAjPc889ZzU6LVq0MHxhyYSAEBACdSFAYU82bWdoByn8F5XAGC/Ngw8+aDOXEPXSmZywfVDDk0INHrSDeGgaN25sPcyEoNAfFmMQFQ6YzgjR3XHHHTlvCTFDs0NLC0JqJ554otUnMjaZEBDR0TsgBISAEIgRAhyMWrZsab0UhKivvvpqc9BBB4XOlkQoTJ0dkhwIAREKI0MTr3E+oxUOhzaIFZ4SwuKQBpIsCDmVKnPzmGOOqREZE+6ikCCenKDPI1kDrxfp93jk8YCjuSTcJateBER0qnftNXMhIARiiACtEtCzYPmyi2hA/Mgjj1hShLeZUBeZmq5Rb77pETbHy0x4CU0MISc8MxQVLbchdIbQOWMcd999t+0/WIiBI02KqZEG2aNYIvomCJysuhAQ0amu9dZshYAQiDkCkBw2aQzvCR4Kwt10BMdLMX/+fLt5k8od1KgqDHFo06aNrRdG8gL/TxuYOBjeJyoiU+IDY1wUFoR8FWt4siZOnGh7bNEKB73Q8OHDTbdu3Yq9tT6fEAREdBKyUBqmEBAC1YEA6dZhSAyoIAJGG4hmBuEuHhknWsZrE/cUbMJTCJCdobG5/PLLI19wCCTiZTRALru2f//+ttWELL0IiOikd201MyEgBBKIALVjqIWFvfnmm7VmAAmiQCDkhawsNmgEwEk3OqbT2RwjfEZvPuZZKoNITp061VxzzTWGbDPqjhHaoi6RLH0IiOikb001IyEgBFKCwLx588xnn31mPTaEcdLY24nMVUTXhK8QHdPGgjT3chkZsWh56CEGgcQzduaZZyo7tlwLUIbniOiUAWQ9QggIASEgBLIjQNo8oSoMjxVZZvTkK7fR5xBh93nnnWcbjdLqhz6Hu+++u3pqlXsxIn6eiE7EgOp2QkAICAEhEBwB6vH41Z8hGZUuiEqRWDK+8CyRsdWpUyfbT2yvvfYKPjFdGRsERHRisxQaiBAQAkKguhCghxXhIgwB9SmnnGJTwONiVF8mrIWXiVpEhNjwNg0aNMh6fGTJQEBEJxnrpFEKASEgBFKHwJAhQ8xFF11k54U+Z9KkSbWyr+I0YaovU4iQ5qZvv/22HRqlAEjVp5K1LL4IiOjEd200MiEgBIRAqhEYMGCAzXxyFoewVT7A8UKRDn/GGWdYbREaI1pikA5PqrosfgiI6MRvTTQiISAEhEBVIEAlZCoiYzQvpsJzksz3SPXs2dNMmDAhScOvmrGK6FTNUmuiQkAICIF4IUANICo9Y/SkGj16dLwGmGM048ePN71797ZXNG/e3Nx777226rQsfgiI6MRvTTQiISAEhEBVIEDBQ7qnYzQgTULzTSoqjxo1ypx99tl23MzhgQcesM1PZfFEQEQnnuuiUQkBISAEUo8AvbxeeOEFO8/zzz/fZl3F1dAPjRw50lZwpsghRhVnUtHx6Mjii4CITnzXRiMTAkJACKQagauuusqccMIJdo6NGjUyCxcujF31Z8ZIVhVj8w2Sg74IsiaLNwIiOvFeH41OCAgBIZBaBD788EPTsWPHmp5etGHo27dvxef7008/2QrJtILItFVWWcUMHDjQDBs2zKy99toVH6sGkB8BEZ38GOkKISAEhIAQKBECTz/9tG2z8P3335uVV17ZkL1EFeJyF+T78ccfDQLjKVOmmNmzZ5tPP/201ozXXHNN6306/vjj1QerRO9CqW4rolMqZHVfISAEhIAQyIvAW2+9ZZo1a2aWLVtWcy1hLMgP3pNFixaZadOmmU022cT06NHDin7pdr7aaqvlvXe+C2joeeedd5o5c+YYCgJ+9dVXy32E59Dok2KBbdq0yXdL/XsMERDRieGiaEhCQAgIgWpCYMyYMbbYHqTi66+/zjv1hg0b2o7u6667rlmyZIlZvHix/Wy9evXMOuusY/bYYw/DNfzdrrvuaknMJ598Yq+bO3euFUDTFT6XtWjRwlDnh8aeq666at4x6YL4IiCiE9+10ciEgBAQAlWFAERk7NixNdoYPDtbbLGFWbBggSU0/JTSCE916dLF9OnTx3qUaEshSz4CIjrJX0PNQAgIASGQegS+++4789hjj5mnnnrKamhmzZpVk+ZdzOTx/Oy4446mV69eltysvvrqxdxOn40hAiI6MVwUDUkICAEhIATyI0D4ad68ectdiOfnxRdftH8/Y8YM07RpU7PhhhvanlQ77LCDDXvVr1/ftGzZUl6b/DAn/goRncQvoSYgBISAEBACQkAI1IWAiI7eDSEgBISAEBACQiC1CIjopHZpNTEhIASEgBAQAkJAREfvgBAQAkJACAgBIZBaBER0Uru0mpgQEAJCQAgIASEgoqN3QAgIASEgBISAEEgtAiI6qV1aTUwICAEhIASEgBAQ0dE7IASEgBAQAkJACKQWARGd1C6tJiYEhIAQEAJCQAiI6OgdEAJCQAgIASEgBFKLgIhOapdWExMCQkAICAEhIAREdPQOCAEhIASEgBAQAqlFQEQntUuriQkBISAEhIAQEAIiOnoHhIAQEAJCQAgIgdQiIKKT2qXVxISAEBACQkAICAERHb0DQkAICAEhIASEQGoRENFJ7dJqYkJACAgBISAEhMD/ARBCb6dRmQ9GAAAAAElFTkSuQmCC', 1),
(25, 2025895161, 11, 2, 1, '2025-06-10', '2025-06-28', 1, 0, 6750.00, 0.00, 6750.00, '', NULL, 0),
(27, 2025738393, 11, 8, 8, '2025-06-15', '2025-06-17', 1, 0, 2700.00, 1500.00, 1200.00, '', NULL, 0),
(26, 2025768497, 11, 2, 2, '2025-06-13', '2025-06-16', 1, 0, 13500.00, 1450.00, 12050.00, '', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cp_invoice_items`
--

CREATE TABLE `cp_invoice_items` (
  `id` bigint(11) NOT NULL,
  `inv_id` bigint(11) DEFAULT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `order_qty` int(11) DEFAULT NULL,
  `free_issues` int(11) DEFAULT NULL,
  `sales_price` double(10,2) DEFAULT NULL,
  `total` double(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cp_invoice_items`
--

INSERT INTO `cp_invoice_items` (`id`, `inv_id`, `item_code`, `item_name`, `order_qty`, `free_issues`, `sales_price`, `total`) VALUES
(17, 2025984963, '1111', 'Ice Cream Vani 1L', 10, 1, 1350.00, 13500.00),
(18, 2025984963, '1113', 'Ice Cream Vni1 4L Tub', 5, 0, 1450.00, 7250.00),
(19, 2025984963, '1113', 'Ice Cream Vni1 4L Tub', 10, 1, 1450.00, 14500.00),
(21, 2025895161, '1111', 'Ice Cream Vani 1L', 5, 0, 1350.00, 6750.00),
(22, 2025768497, '1111', 'Ice Cream Vani 1L', 10, 0, 1350.00, 13500.00),
(23, 2025738393, '1111', 'Ice Cream Vani 1L', 2, 0, 1350.00, 2700.00);

-- --------------------------------------------------------

--
-- Table structure for table `cp_inv_payment`
--

CREATE TABLE `cp_inv_payment` (
  `payment_id` int(11) NOT NULL,
  `p_inv_id` int(11) DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `cash_amount` double(10,2) DEFAULT NULL,
  `cheq_amount` double(10,2) DEFAULT NULL,
  `cheq_date` date DEFAULT NULL,
  `cheq_detail` text,
  `notes` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cp_inv_payment`
--

INSERT INTO `cp_inv_payment` (`payment_id`, `p_inv_id`, `pay_date`, `cash_amount`, `cheq_amount`, `cheq_date`, `cheq_detail`, `notes`) VALUES
(1122, 2025768497, '2025-06-15', 12050.00, 0.00, NULL, '', ''),
(1121, 2025895161, '2025-06-10', 0.00, 500.00, '2025-06-14', '111111-1111-111', ''),
(1119, 2025895161, '2025-06-09', 1000.00, 0.00, NULL, '', ''),
(1120, 2025895161, '2025-06-10', 750.00, 0.00, NULL, '', ''),
(1118, 2025984963, '2025-06-03', 17100.00, 17100.00, '2025-06-04', '125255-1588-582', 'cheque');

-- --------------------------------------------------------

--
-- Table structure for table `cp_Items`
--

CREATE TABLE `cp_Items` (
  `id` bigint(20) NOT NULL,
  `item_code` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `notes` text,
  `cost_price` decimal(10,2) DEFAULT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cp_Items`
--

INSERT INTO `cp_Items` (`id`, `item_code`, `name`, `notes`, `cost_price`, `sale_price`) VALUES
(1, '1111', 'Ice Cream Vani 1L', 'Vanilla 1L', 950.00, 1350.00),
(2, '1112', 'Ice Cream Stw 1L', 'Strwbarry 1L', 1050.00, 1450.00),
(3, '1113', 'Ice Cream Vni1 4L Tub', 'Vanill 4L tab', 1050.00, 1450.00),
(4, '130669-111', 'Ice Cream Stw 2L', 'Ice Cream Stw 2L ', 500.00, 1500.00),
(5, '965060', 'Ice Cream Mango 4L', '1 Free issue for 10', 850.00, 1050.00);

-- --------------------------------------------------------

--
-- Table structure for table `cp_logs`
--

CREATE TABLE `cp_logs` (
  `id` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `logdate` date DEFAULT NULL,
  `logtime` time DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cp_rep`
--

CREATE TABLE `cp_rep` (
  `id` int(11) NOT NULL,
  `rep_name` varchar(255) DEFAULT NULL,
  `rep_address` varchar(255) DEFAULT NULL,
  `rep_mob1` int(10) DEFAULT NULL,
  `rep_mob2` int(10) DEFAULT NULL,
  `rep_notes` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cp_rep`
--

INSERT INTO `cp_rep` (`id`, `rep_name`, `rep_address`, `rep_mob1`, `rep_mob2`, `rep_notes`) VALUES
(2, 'Nimal', 'No 101 payagala', 2147483647, 2147483647, 'xcsc cscsc'),
(8, 'Kamal', 'aaaaa', 23423, 23423423, 'aaaaa'),
(4, 'Denish', 'sacasc', 232332, 2323, 'bbbbbbbbbbbbbbbb');

-- --------------------------------------------------------

--
-- Table structure for table `cp_return_items`
--

CREATE TABLE `cp_return_items` (
  `id` int(11) NOT NULL,
  `inv_id` bigint(20) DEFAULT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `ret_state` varchar(255) DEFAULT NULL,
  `ret_qty` int(11) DEFAULT NULL,
  `sale_price` double(10,2) DEFAULT NULL,
  `total` double(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cp_return_items`
--

INSERT INTO `cp_return_items` (`id`, `inv_id`, `item_code`, `item_name`, `ret_state`, `ret_qty`, `sale_price`, `total`) VALUES
(7, 2025984963, '965060', 'Ice Cream Mango 4L', 'Expired', 1, 1050.00, 1050.00),
(9, 2025768497, '1112', 'Ice Cream Stw 1L', 'Expired', 1, 1450.00, 1450.00),
(10, 2025738393, '130669-111', 'Ice Cream Stw 2L', 'Expired', 1, 1500.00, 1500.00);

-- --------------------------------------------------------

--
-- Table structure for table `cp_root`
--

CREATE TABLE `cp_root` (
  `id` int(11) NOT NULL,
  `root_id` int(11) DEFAULT NULL,
  `root_name` varchar(255) DEFAULT NULL,
  `root_notes` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cp_root`
--

INSERT INTO `cp_root` (`id`, `root_id`, `root_name`, `root_notes`) VALUES
(1, 5033, 'Kalutara', 'cscs scsc'),
(2, 1602, 'payagala', 'dccdc'),
(8, 2788, 'Anuradapura', 'wwww'),
(5, 3829, 'Kalaniya', 'sdc sd  sd  ssd  sd');

-- --------------------------------------------------------

--
-- Table structure for table `cp_settings`
--

CREATE TABLE `cp_settings` (
  `setting_id` int(11) NOT NULL,
  `showrecords` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cp_settings`
--

INSERT INTO `cp_settings` (`setting_id`, `showrecords`) VALUES
(1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `cp_userpermission`
--

CREATE TABLE `cp_userpermission` (
  `per_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `OnOff` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cp_userpermission`
--

INSERT INTO `cp_userpermission` (`per_id`, `permission_id`, `uid`, `OnOff`) VALUES
(1, 1111, 2, 1),
(3, 1112, 2, 1),
(45, 1127, 2, 1),
(31, 1113, 2, 1),
(32, 1114, 2, 1),
(33, 1115, 2, 1),
(34, 1116, 2, 1),
(35, 1117, 2, 1),
(36, 1118, 2, 1),
(37, 1119, 2, 1),
(38, 1120, 2, 1),
(39, 1121, 2, 1),
(40, 1122, 2, 1),
(41, 1123, 2, 1),
(42, 1124, 2, 1),
(43, 1125, 2, 1),
(44, 1126, 2, 1),
(63, 1128, 2, 1),
(136, 1129, 2, 1),
(1437, 1132, 2, 1),
(1373, 1131, 2, 1),
(1372, 1130, 2, 1),
(1610, 1111, 10670, 1),
(1611, 1112, 10670, 1),
(1612, 1113, 10670, 1),
(1613, 1114, 10670, 1),
(1614, 1115, 10670, 1),
(1615, 1116, 10670, 0),
(1616, 1130, 10670, 0),
(1617, 1117, 10670, 0),
(1618, 1118, 10670, 0),
(1619, 1119, 10670, 0),
(1620, 1120, 10670, 0),
(1621, 1129, 10670, 0),
(1622, 1123, 10670, 0),
(1623, 1124, 10670, 1),
(1624, 1125, 10670, 0),
(1625, 1127, 10670, 0),
(1626, 1128, 10670, 0),
(1627, 1121, 10670, 0),
(1628, 1122, 10670, 0),
(1704, 1122, 34703, 0),
(1703, 1121, 34703, 0),
(1702, 1128, 34703, 0),
(1701, 1127, 34703, 0),
(1700, 1125, 34703, 0),
(1699, 1124, 34703, 0),
(1698, 1123, 34703, 0),
(1697, 1129, 34703, 0),
(1696, 1120, 34703, 0),
(1695, 1119, 34703, 1),
(1694, 1118, 34703, 0),
(1693, 1117, 34703, 0),
(1692, 1130, 34703, 0),
(1691, 1116, 34703, 1),
(1690, 1115, 34703, 1),
(1689, 1114, 34703, 0),
(1688, 1113, 34703, 0),
(1687, 1112, 34703, 0),
(1686, 1111, 34703, 0),
(1685, 1122, 79662, 0),
(1684, 1121, 79662, 1),
(1683, 1128, 79662, 0),
(1682, 1127, 79662, 0),
(1681, 1125, 79662, 0),
(1680, 1124, 79662, 0),
(1679, 1123, 79662, 0),
(1678, 1129, 79662, 0),
(1677, 1120, 79662, 0),
(1676, 1119, 79662, 0),
(1675, 1118, 79662, 0),
(1674, 1117, 79662, 0),
(1673, 1130, 79662, 0),
(1672, 1116, 79662, 0),
(1671, 1115, 79662, 1),
(1670, 1114, 79662, 0),
(1669, 1113, 79662, 0),
(1668, 1112, 79662, 0),
(1667, 1111, 79662, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cp_users`
--

CREATE TABLE `cp_users` (
  `id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `rep_id` int(11) NOT NULL,
  `can_view_all_inv` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cp_users`
--

INSERT INTO `cp_users` (`id`, `username`, `password`, `firstname`, `lastname`, `rep_id`, `can_view_all_inv`) VALUES
(2, 'admin', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'Admin', 'SalesRep', 0, 1),
(34703, 'nimal1992', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'Nimal', 'Perera', 2, 0),
(79662, 'demo1992', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'Demo', 'User', 8, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cp_customers`
--
ALTER TABLE `cp_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cp_invoice`
--
ALTER TABLE `cp_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cp_invoice_items`
--
ALTER TABLE `cp_invoice_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cp_inv_payment`
--
ALTER TABLE `cp_inv_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `cp_Items`
--
ALTER TABLE `cp_Items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cp_logs`
--
ALTER TABLE `cp_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cp_rep`
--
ALTER TABLE `cp_rep`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cp_return_items`
--
ALTER TABLE `cp_return_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cp_root`
--
ALTER TABLE `cp_root`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cp_settings`
--
ALTER TABLE `cp_settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `cp_userpermission`
--
ALTER TABLE `cp_userpermission`
  ADD PRIMARY KEY (`per_id`);

--
-- Indexes for table `cp_users`
--
ALTER TABLE `cp_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cp_customers`
--
ALTER TABLE `cp_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `cp_invoice`
--
ALTER TABLE `cp_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `cp_invoice_items`
--
ALTER TABLE `cp_invoice_items`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `cp_inv_payment`
--
ALTER TABLE `cp_inv_payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1123;

--
-- AUTO_INCREMENT for table `cp_Items`
--
ALTER TABLE `cp_Items`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cp_logs`
--
ALTER TABLE `cp_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `cp_rep`
--
ALTER TABLE `cp_rep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cp_return_items`
--
ALTER TABLE `cp_return_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cp_root`
--
ALTER TABLE `cp_root`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cp_settings`
--
ALTER TABLE `cp_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cp_userpermission`
--
ALTER TABLE `cp_userpermission`
  MODIFY `per_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1705;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
