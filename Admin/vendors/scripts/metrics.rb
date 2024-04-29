require 'json'
require 'sys/cpu'
require 'sys/filesystem'
require 'sys/proctable'
require 'sys/netinfo'

# Méthode pour obtenir l'utilisation du CPU
def cpu_usage
  Sys::CPU.load_avg[0] * 100
end

# Méthode pour obtenir l'utilisation de la RAM
def ram_usage
  total_memory = Sys::Filesystem.stat('/')['total_bytes']
  used_memory = total_memory - Sys::Proctable.ps.sum { |p| p.mem }
  (used_memory / total_memory.to_f) * 100
end

# Méthode pour obtenir l'utilisation du réseau
def network_usage
  net_info = Sys::NetInfo.get
  (net_info[:in_bytes].to_f / net_info[:total_bytes].to_f) * 100
end

# Générer les données pour les balises input
cpu_value = cpu_usage.round(2)
ram_value = ram_usage.round(2)
network_value = network_usage.round(2)

# Formatage des données en JSON pour JavaScript
data = {
  cpu: cpu_value,
  ram: ram_value,
  network: network_value
}.to_json

# Affichage des données en JSON
puts data
