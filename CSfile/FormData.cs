using System.Text.Json.Serialization;

namespace MultiStepInputPage.Models
{
    public class FormData
    {
        //[JsonPropertyName("id")]
        //public string? Id { get; set; }

        [JsonPropertyName("booth_number")]
        public string? BoothNumber { get; set; }

        [JsonPropertyName("beacon_id")]
        public string? BeaconId { get; set; }

        [JsonPropertyName("company_name")]
        public string? CompanyName { get; set; }

        [JsonPropertyName("description")]
        public string? Description { get; set; }

        [JsonPropertyName("postimageurl")]
        public string? PostImageUrl { get; set; }

        [JsonPropertyName("youtubeurl")]
        public string? YoutubeUrl { get; set; }
    }
}